<?php
/**
 * +----------------------------------------------------------------------
 * |
 * +----------------------------------------------------------------------
 * | Author: lidong <947714443@qq.com>
 * +----------------------------------------------------------------------
 * | Date 2019/10/26 0026
 * +----------------------------------------------------------------------
 * | File Describe:
 */
namespace think\paginator\driver;

use think\Paginator;

/**
 * Describe:
 * Class Bootstrap1
 *
 * @package think\paginator\driver
 * @author  lidong<947714443@qq.com>
 * @date    2019/10/26 0026
 */
class Bootstrap1 extends Paginator {

    /**
     * Describe:公共样式
     *
     * @var string
     */
    protected $common_style = '';

    /**
     * Describe:激活样式
     *
     * @var string
     */
    protected $active_style = '';

    /**
     * Describe: 禁用样式
     *
     * @var string
     */
    protected $disabled_style = '';


    /**
     * Bootstrap1 constructor.
     * 分页输出初始化
     *
     * @param       $items
     * @param       $listRows
     * @param null  $currentPage
     * @param null  $total
     * @param bool  $simple
     * @param array $options
     */
    public function __construct($items, $listRows, $currentPage = null, $total = null, $simple = false, $options = []) {
        parent::__construct($items, $listRows, $currentPage, $total, $simple, $options);
        $this->common_style = $this->getCommonStyle() ? : ''; /* 获取配置的公共样式 */
        $this->active_style = $this->getActiveStyle() ? : 'active'; /* 获取配置的激活样式 */
        $this->disabled_style = $this->getDisabledStyle() ? : 'disabled'; /* 获取配置的禁用样式*/ //
        // $this->disabled_style = $this->getDisabledStyle() ? : 'disabled'; /* 获取配置的禁用样式*/
        // $this->disabled_style = $this->getDisabledStyle() ? : 'disabled'; /* 获取配置的禁用样式*/
        // $this->disabled_style = $this->getDisabledStyle() ? : 'disabled'; /* 获取配置的禁用样式*/
        // $this->disabled_style = $this->getDisabledStyle() ? : 'disabled'; /* 获取配置的禁用样式*/
        // $this->disabled_style = $this->getDisabledStyle() ? : 'disabled'; /* 获取配置的禁用样式*/
    }


    /**
     * Describe:首页按钮
     *
     * @param string $text
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getFirstButton($text = '') {
        $text = $this->getFirstText($text);
        $class = $this->getFirstStyle();
        if ($this->currentPage() <= 1) {
            return '';
            /*return $this->getDisabledTextWrapper($text);*/
        }
        $url = $this->url(1);
        return $this->getPageLinkWrapper($url, $text, $class);
    }


    /**
     * Describe:尾页按钮
     *
     * @param string $text
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getLastButton($text = '') {
        $text = $this->getLastText($text);
        $class = $this->getLastStyle();
        if (!$this->hasMore) {
            return '';
            /*return $this->getDisabledTextWrapper($text);*/
        }
        $url = $this->url($this->lastPage);
        return $this->getPageLinkWrapper($url, $text, $class);
    }


    /**
     * 上一页按钮
     *
     * @param string $text
     *
     * @return string
     */
    protected function getPreviousButton($text = '') {
        $text = $this->getPreviousText($text);
        $class = $this->getPreviousStyle();
        if ($this->currentPage() <= 1) {
            return $this->getDisabledTextWrapper($text, $class);
        }
        $url = $this->url($this->currentPage() - 1);
        return $this->getPageLinkWrapper($url, $text, $class);
    }


    /**
     * 下一页按钮
     *
     * @param string $text
     *
     * @return string
     */
    protected function getNextButton($text = '') {
        $text = $this->getNextText($text);
        $class = $this->getNextStyle();
        if (!$this->hasMore) {
            return $this->getDisabledTextWrapper($text);
        }
        $url = $this->url($this->currentPage() + 1);
        return $this->getPageLinkWrapper($url, $text, $class);
    }


    /**
     * 页码按钮
     *
     * @return string
     */
    protected function getLinks() {
        if ($this->simple) {
            return '';
        }
        $block = [
            'first'  => null,
            'slider' => null,
            'last'   => null,
        ];
        $side = 3;
        $window = $side * 2;
        if ($this->lastPage < $window + 6) {
            $block['first'] = $this->getUrlRange(1, $this->lastPage);
        } elseif ($this->currentPage <= $window) {
            $block['first'] = $this->getUrlRange(1, $window + 2);
            $block['last'] = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        } elseif ($this->currentPage > ($this->lastPage - $window)) {
            $block['first'] = $this->getUrlRange(1, 2);
            $block['last'] = $this->getUrlRange($this->lastPage - ($window + 2), $this->lastPage);
        } else {
            $block['first'] = $this->getUrlRange(1, 2);
            $block['slider'] = $this->getUrlRange($this->currentPage - $side, $this->currentPage + $side);
            $block['last'] = $this->getUrlRange($this->lastPage - 1, $this->lastPage);
        }
        $html = '';
        if (is_array($block['first'])) {
            $html .= $this->getUrlLinks($block['first']);
        }
        if (is_array($block['slider'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['slider']);
        }
        if (is_array($block['last'])) {
            $html .= $this->getDots();
            $html .= $this->getUrlLinks($block['last']);
        }
        return $html;
    }


    /**
     * 渲染分页html
     *
     * @return mixed
     */
    public function render() {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf('<ul class="pagination">%s %s</ul>', $this->getPreviousButton(), $this->getNextButton());
            } else {
                return sprintf('<ul class="pagination">%s %s %s %s %s</ul>', $this->getFirstButton(), $this->getPreviousButton(), $this->getLinks(), $this->getNextButton(), $this->getLastButton());
            }
        }
    }


    /**
     * 生成一个可点击的按钮
     *
     * @param string $url
     * @param int    $page
     * @param string $class
     *
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $class = '') {
        return '<li  class="' . $this->common_style . ' ' . $class . ' ' . $this->getAvailableStyle() . '" ><a href="' . htmlentities($url) . '"  class="page-link">' . $page . '</a></li>';
    }


    /**
     * 生成一个禁用的按钮
     *
     * @param string $text
     * @param string $class
     *
     * @return string
     */
    protected function getDisabledTextWrapper($text, $class = '') {
        return '<li class="' . $this->common_style . ' ' . $class . ' ' . $this->disabled_style . '"><a href="javascript:;" class="page-link">' . $text . '</a></li>';
    }


    /**
     * 生成一个激活的按钮
     *
     * @param string $text
     * @param string $class
     *
     * @return string
     */
    protected function getActivePageWrapper($text, $class = '') {
        return '<li class="' . $this->common_style . ' ' . $class . ' ' . $this->active_style . '"><a href="javascript:;" class="page-link">' . $text . '</a></li>';
    }


    /**
     * 生成省略号按钮
     *
     * @return string
     */
    protected function getDots() {
        return $this->getDisabledTextWrapper('...');
    }


    /**
     * 批量生成页码按钮.
     *
     * @param array $urls
     *
     * @return string
     */
    protected function getUrlLinks(array $urls) {
        $html = '';
        foreach ($urls as $page => $url) {
            $html .= $this->getPageLinkWrapper($url, $page);
        }
        return $html;
    }


    /**
     * 生成普通页码按钮
     *
     * @param string $url
     * @param int    $page
     * @param string $class
     *
     * @return string
     */
    protected function getPageLinkWrapper($url, $page, $class = '') {
        if ($this->currentPage() == $page) {
            return $this->getActivePageWrapper($page, $class);
        }
        return $this->getAvailablePageWrapper($url, $page, $class);
    }


    /**
     * Describe:获取公共样式
     *
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getCommonStyle() {
        $style = empty($this->options['common_style']) ? '' : $this->options['common_style'];
        return $style;
    }


    /**
     * Describe:可点击按钮样式
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getAvailableStyle() {
        $style = empty($this->options['available_style']) ? '' : $this->options['available_style'];
        return $style;
    }


    /**
     * Describe:上一页按钮样式
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getPreviousStyle() {
        $style = empty($this->options['pre_style']) ? '' : $this->options['pre_style'];
        return $style;
    }


    /**
     * Describe:下一页按钮样式
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getNextStyle() {
        $style = empty($this->options['next_style']) ? '' : $this->options['next_style'];
        return $style;
    }


    /**
     * Describe:禁用按钮样式
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getDisabledStyle() {
        $style = empty($this->options['disabled_style']) ? '' : $this->options['disabled_style'];
        return $style;
    }


    /**
     * Describe:激活按钮样式
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getActiveStyle() {
        $style = empty($this->options['active_style']) ? '' : $this->options['active_style'];
        return $style;
    }


    /**
     * Describe:首页按钮样式
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getFirstStyle() {
        $style = empty($this->options['first_style']) ? '' : $this->options['first_style'];
        return $style;
    }


    /**
     * Describe:尾页按钮样式
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getLastStyle() {
        $style = empty($this->options['last_style']) ? '' : $this->options['last_style'];
        return $style;
    }


    /**
     * Describe:上一页显示文字
     *
     * @param string $text 显示文字
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getPreviousText($text = '') {
        $text = empty($this->options['pre_text']) ? (empty($text) ? '&lsaquo;' : $text) : $this->options['pre_text'];
        return $text;
    }


    /**
     * Describe:下一页显示文字
     *
     * @param string $text 显示文字
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getNextText($text = '') {
        $text = empty($this->options['next_text']) ? (empty($text) ? '&rsaquo;' : $text) : $this->options['next_text'];
        return $text;
    }


    /**
     * Describe:首页显示文字
     *
     * @param string $text 显示文字
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getFirstText($text = '') {
        $text = empty($this->options['first_text']) ? (empty($text) ? '&laquo;' : $text) : $this->options['first_text'];
        return $text;
    }


    /**
     * Describe:尾页显示文字
     *
     * @param string $text
     *
     * @return string
     * @author lidong<947714443@qq.com>
     * @date   2019/10/26 0026
     */
    protected function getLastText($text = '') {
        $text = empty($this->options['last_text']) ? (empty($text) ? '&raquo;' : $text) : $this->options['last_text'];
        return $text;
    }


}