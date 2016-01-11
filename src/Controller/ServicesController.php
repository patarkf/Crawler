<?php
namespace Crawler\Controller;

use Crawler\Controller\AppController;

/**
 * Services Controller
 *
 * @property \Crawler\Model\Table\ServicesTable $Services
 */
class ServicesController extends AppController
{

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
