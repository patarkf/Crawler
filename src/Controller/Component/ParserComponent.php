<?php
namespace Crawler\Controller\Component;

use Cake\Controller\Component;

class ParserComponent extends Component
{
    /**
     * It reads and extract a HTML page and load it with
     * the DOMDocument.
     * @param  string $pageUrl Url of the HTML page
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
     * @param \DOMDocument $dom
     * @param $pageUrl
     * @return array
     */
    public function parseForLinks(\DOMDocument $dom, $pageUrl, $tag, $attr)
    {
        $foundLinks = [];
        foreach ($dom->getElementsByTagName($tag) as $key => $link) {

            if ($key >= 100) {
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

    public function countTheOccurrencesOfHttpResponses($links)
    {
        $httpStatusOccurrences = array_count_values(
            array_map(function ($value) {
                return $value['httpStatus'];
            }, $links)
        );

        return $httpStatusOccurrences;
    }

    protected function _orderLinks($foundLinks)
    {
        usort($foundLinks, function ($a, $b) {
            return $a['httpStatus'] - $b['httpStatus'];
        });

        return $foundLinks;
    }

    /**
     * @param $relative
     * @param $base
     * @return mixed|string
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
     * @param $base
     * @param $relative
     * @return string
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
