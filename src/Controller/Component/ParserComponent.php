<?php
/**
 * Crawler
 * A HTML parser plugin for CakePHP 3
 *
 * @author Patrick Ferreira <paatrickferreira@gmail.com>
 * @link          https://github.com/patarkf/Crawler Crawler plugin to CakePHP
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Crawler\Controller\Component;

use Cake\Controller\Component;

class ParserComponent extends Component
{

    /**
     * It reads and extract a HTML page and load it with
     * the DOMDocument.
     *
     * @param  string $pageUrl Url of the page
     * @return \DOMDocument
     */
    public function initializeDom($pageUrl)
    {
        $html = file_get_contents($pageUrl);
        $dom = new \DOMDocument;
        $dom->loadHTML($html);

        return $dom;
    }

    /**
     * Main function of the Parser component. It's responsible for read and iterate
     * the DOM object and extract every element based on the tag and attr passed
     * as parameters. It uses Curl to make a request to every link of the page and
     * verifies the HTTP status of every one.
     *
     * @param \DOMDocument $dom DOM object with HTML loaded
     * @param string $pageUrl Url of the target page
     * @param string $tag Target tag
     * @param string $attr The attr of the target tag
     * @param int $limit Limit of links that the crawler will search
     * @return array Array of found links
     */
    public function parseForLinks(\DOMDocument $dom, $pageUrl, $tag, $attr, $limit = null)
    {
        $foundLinks = [];
        foreach ($dom->getElementsByTagName($tag) as $key => $link) {

            if ($this->_checkIfItHasReachedTheLimitOfLinks($key, $limit)) {
                break;
            }

            $href = $link->getAttribute($attr);
            if (!strlen($href) || $href[0] == '#' || preg_match("'^javascript'i", $href)) {
                continue;
            }

            $absolutePath = $this->_convertRelativePathToAbsolute($href, $pageUrl);
            $href = preg_replace(["'^[^:]+://'", "'#.+$'"], '', $absolutePath);
            if (isset($done[$href])) {
                continue;
            }

            $curlCommand = 'curl -I -A "Broken Link Checker" -s --max-redirs 5 -m 5 --retry 1 --retry-delay ';
            $curlCommand .= '10 -w "%{url_effective}\t%{http_code}\t%{time_total}" -o temp2.txt ' . escapeshellarg($href);
            $curlCommand = explode("\t", `$curlCommand`);

            $foundLinks[$key]['httpStatus'] = $curlCommand[1];
            $foundLinks[$key]['timeResponse'] = $curlCommand[2];
            $foundLinks[$key]['url'] = $curlCommand[0];

            $done[$href] = true;
        }
        return $this->_orderLinks($foundLinks);
    }

    /**
     * It counts the number of occurrences of every HTTP response
     * obtained by the request.
     *
     * @param array $links Array of links
     * @return array Flat array of HTTP responses and their occurrences
     */
    public function countTheOccurrencesOfHttpResponses($links)
    {
        $httpStatusOccurrences = array_count_values(
            array_map(function ($value) {
                return $value['httpStatus'];
            }, $links)
        );

        return $httpStatusOccurrences;
    }

    /**
     * It checks if the current key of the links array has reached the limit
     * stablished by the user.
     *
     * @param int $currentKey Key of the array that are being iterated
     * @param int|null $limit Limit of links that crawler will search for
     * @return bool False if the key wasn't reached the limit yet and true if it did
     */
    protected function _checkIfItHasReachedTheLimitOfLinks($currentKey, $limit = null)
    {
        if (!empty($limit)) {
            if ($currentKey == $limit) {
                return true;
            }
        }
        return false;
    }

    /**
     * It sorts the links by HTTP status.
     *
     * @param array $foundLinks Array of found links
     * @return mixed Array of found links sorted by HTTP status
     */
    protected function _orderLinks($foundLinks)
    {
        usort($foundLinks, function ($a, $b) {
            return $a['httpStatus'] - $b['httpStatus'];
        });

        return $foundLinks;
    }

    /**
     * It converts a relative path of a link to a absolute path.
     *
     * @param string $relative Relative path to be converted
     * @param string $base Base path (full path of the target url)
     * @return mixed|string Appropriated absolute path
     */
    protected function _convertRelativePathToAbsolute($relative, $base)
    {
        if (!$relative) {
            return $base;
        }

        $path = parse_url($relative);
        if (isset($path['scheme']) && $path['scheme']) {
            if (isset($path['path'])) {
                return $relative;
            }
            $relative = isset($path['query']) ?
            preg_replace("'?'", '/?', $relative, 1) :
            $relative . '/';

            return $relative;
        }

        if ($relative[0] == '#' || $relative[0] == '?') {
            return $base . $relative;
        }
        return $this->_sanitizeAbsoluteUrl($base, $relative);
    }

    /**
     * It cleans the path removing inappropriated characteres or symbols.
     *
     * @param string $base Base path (full path of the target url)
     * @param $relative Relative path to be converted
     * @return string Appropriated abgsolute path
     */
    protected function _sanitizeAbsoluteUrl($base, $relative)
    {
        extract(parse_url($base));
        $path = preg_replace('#/[^/]*$#', '', $path);
        if ($relative[0] == '/') {
            $path = '';
        }
        $absolute = "{$host}{$path}/{$relative}";
        $badCharacters = ['#(/.?/)#', '#/(?!..)[^/]+/../#'];

        // replace '//' or '/./' or '/foo/../' with '/'
        for ($n = 1; $n > 0; $absolute = preg_replace($badCharacters, '/', $absolute, -1, $n));

        return $scheme . '://' . $absolute;
    }
}
