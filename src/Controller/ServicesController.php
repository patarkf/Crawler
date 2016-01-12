<?php
/**
 * Crawler
 * A HTML parser plugin for CakePHP 3
 *
 * @author Patrick Ferreira <paatrickferreira@gmail.com>
 * @link          https://github.com/patarkf/Crawler Crawler plugin to CakePHP
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Crawler\Controller;

use Crawler\Controller\AppController;

/**
 * Services Controller
 *
 * @property \Crawler\Model\Table\ServicesTable $Services
 */
class ServicesController extends AppController
{

    /**
     * It initializes the component
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Crawler.Parser');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->is('post')) {
            $url = $this->request->data['url'];
            $dom = $this->Parser->initializeDom($url);

            $this->set('links', $this->_getLinks($dom, $url));
            $this->set('images', $this->_getImages($dom, $url));
            $this->set('scripts', $this->_getScripts($dom, $url));
            $this->set('cssLinks', $this->_getCssLinks($dom, $url));
        }
    }

    /**
     * Used to get all links "<a>" of a HTML page.
     *
     * @param DOM $dom DOM object with the HTML target page already loaded
     * @param string $url URL of the target page
     * @return array Array containing all the links found, number of links
     * found and also the HTTP responses
     */
    protected function _getLinks($dom, $url)
    {
        $links = $this->Parser->parseForLinks($dom, $url, "a", "href");
        $linksHttpResponses = $this->Parser->countTheOccurrencesOfHttpResponses($links);

        return [
           'links' => $links,
            'numberOfLinks' => count($links),
            'linksHttpResponses' => $linksHttpResponses
        ];
    }

    /**
     * Used to get all links "<img>" of a HTML page.
     *
     * @param DOM $dom DOM object with the HTML target page already loaded
     * @param string $url URL of the target page
     * @return array Array containing all the links found, number of links
     * found and also the HTTP responses
     */
    protected function _getImages($dom, $url)
    {
        $images = $this->Parser->parseForLinks($dom, $url, "img", "src");
        $imagesHttpResponses = $this->Parser->countTheOccurrencesOfHttpResponses($images);

        return [
            'images' => $images,
            'numberOfImages' => count($images),
            'imagesHttpResponses' => $imagesHttpResponses
        ];
    }

    /**
     * Used to get all links "<script>" of a HTML page.
     *
     * @param DOM $dom DOM object with the HTML target page already loaded
     * @param string $url URL of the target page
     * @return array Array containing all the images found, number of images
     * found and also the HTTP responses
     */
    protected function _getScripts($dom, $url)
    {
        $scripts = $this->Parser->parseForLinks($dom, $url, "script", "src");
        $scriptsHttpResponses = $this->Parser->countTheOccurrencesOfHttpResponses($scripts);

        return [
            'scripts' => $scripts,
            'numberOfScripts' => count($scripts),
            'scriptsHttpResponses' => $scriptsHttpResponses
        ];
    }

    /**
     * Used to get all links "<link>" of a HTML page.
     *
     * @param DOM $dom DOM object with the HTML target page already loaded
     * @param string $url URL of the target page
     * @return array Array containing all the css links found, number of css links
     * found and also the HTTP responses
     */
    protected function _getCssLinks($dom, $url)
    {
        $cssLinks = $this->Parser->parseForLinks($dom, $url, "link", "rel");
        $cssLinksHttpResponses = $this->Parser->countTheOccurrencesOfHttpResponses($cssLinks);

        return [
            'cssLinks' => $cssLinks,
            'numberOfCssLinks' => count($cssLinks),
            'cssLinksHttpResponses' => $cssLinksHttpResponses
        ];
    }
}
