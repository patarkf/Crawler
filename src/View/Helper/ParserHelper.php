<?php
namespace Crawler\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\View\StringTemplateTrait;

class ParserHelper extends Helper
{
    use StringTemplateTrait;

    protected $_defaultConfig = [
        'templates' => [
            'badge' => '<span class="label-as-badge {{class}}">{{content}}</span>',
            'countBadge' => '<span class="badge {{class}}">{{content}}</span>'
        ],
    ];

    /**
     * @param $httpStatus string
     * @return null|string
     */
    public function httpResponseBadge($httpStatus)
    {
        $httpStatus = (string) $httpStatus;
        $class = $this->_setColorClassByHttpRequest($httpStatus[0]);

        $templater = $this->templater();
        return $templater->format('badge', [
            'class' => $class,
            'content' => $httpStatus,
        ]);
    }

    /**
     * @param $httpStatus string
     * @return null|string
     */
    public function httpResponseCountBadge($httpStatus, $numberOfOccurrences)
    {
        $httpStatus = (string) $httpStatus;
        $class = $this->_setColorClassByHttpRequest($httpStatus[0]);

        $content = $httpStatus . ': ' . $numberOfOccurrences;

        $templater = $this->templater();
        return $templater->format('countBadge', [
            'class' => $class,
            'content' => $content,
        ]);
    }

    /**
     * @param $httpStatus string
     * @return null|string
     */
    protected function _setColorClassByHttpRequest($firstCharacterOfHttpStatus)
    {
        $class = null;
        if ($firstCharacterOfHttpStatus == '2') {
            $class = 'alert-success';
        } elseif ($firstCharacterOfHttpStatus == '3') {
            $class = 'alert-warning';
        } else {
            $class = 'alert-danger';
        }
        return $class;
    }
}
