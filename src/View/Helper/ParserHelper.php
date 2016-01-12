<?php
/**
 * Crawler
 * A HTML parser plugin for CakePHP 3
 *
 * @author Patrick Ferreira <paatrickferreira@gmail.com>
 * @link          https://github.com/patarkf/Crawler Crawler plugin to CakePHP
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Crawler\View\Helper;

use Cake\View\Helper;
use Cake\View\StringTemplateTrait;

class ParserHelper extends Helper
{

    use StringTemplateTrait;

    /**
     * Default config for the helper.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'templates' => [
            'badge' => '<span class="label-as-badge {{class}}">{{content}}</span>',
            'countBadge' => '<span class="badge {{class}}">{{content}}</span>'
        ],
    ];

    /**
     * It creates a Bootstrap badge with the HTTP response
     * passed as parameter.
     *
     * @param string $httpStatus HTTP response
     * @return null|string The badge with the appropriate class
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
     * It creates a Bootstrap badge with the HTTP response and
     * with the number of occurrences of that response.
     *
     * @param string $httpStatus HTTP response (200, 404, etc)
     * @param int $numberOfOccurrences Number of occurrences by HTTP response
     * @return null|string The badge with the appropriate class
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
     * It sets a CSS class to the badge based on the first character of the HTTP response.
     * For example: Good responses will have a "green" color class, etc.
     *
     * @param string $firstCharacterOfHttpStatus First character of the HTTP response
     * @return null|string The appropriate CSS class
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
