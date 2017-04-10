<?php namespace Arcanesoft\Core\Helpers\UI;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

/**
 * Class     Link
 *
 * @package  Arcanesoft\Core\Helpers\UI
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Link implements Htmlable
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /** @var string */
    protected $action;

    /** @var string */
    protected $url;

    /** @var \Illuminate\Support\Collection */
    protected $attributes;

    /** @var bool */
    protected $disabled;

    /** @var string */
    protected $size = 'md';

    /** @var bool */
    public $withTitle = true;

    /** @var bool */
    protected $withIcon = true;

    /** @var bool */
    protected $withTooltip = false;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * LinkElement constructor.
     *
     * @param  string  $action
     * @param  string  $url
     * @param  array   $attributes
     * @param  bool    $disabled
     */
    public function __construct($action, $url, array $attributes = [], $disabled = false)
    {
        $this->action     = $action;
        $this->url        = $url;
        $this->setAttributes($attributes);
        $this->setDisabled($disabled);
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the action title.
     *
     * @return string
     */
    protected function getActionTitle()
    {
        return Str::ucfirst(trans("core::actions.{$this->action}"));
    }

    /**
     * Set the attributes.
     *
     * @param  array  $attributes
     *
     * @return self
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = collect($attributes);

        return $this;
    }

    /**
     * Set an attribute.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function setAttribute($key, $value)
    {
        $this->attributes->put($key, $value);

        return $this;
    }

    /**
     * Set disabled state.
     *
     * @param  bool  $disabled
     *
     * @return self
     */
    public function setDisabled($disabled)
    {
        $this->disabled = (bool) $disabled;

        if ($this->disabled) {
            $this->attributes = $this->attributes->reject(function ($value, $key) {
                return Str::startsWith($key, ['data-']);
            });
        }

        return $this;
    }

    /**
     * Set the size.
     *
     * @param  string  $size
     *
     * @return self
     */
    public function size($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @param  bool  $withTitle
     *
     * @return self
     */
    public function withTitle($withTitle)
    {
        $this->withTitle = $withTitle;

        return $this;
    }

    /**
     * Show/Hide the icon.
     *
     * @var  bool  $withIcon
     *
     * @return self
     */
    public function withIcon($withIcon)
    {
        $this->withIcon = (bool) $withIcon;

        return $this;
    }

    /**
     * Enable the tooltip.
     *
     * @param  bool  $withTooltip
     *
     * @return self
     */
    public function withTooltip($withTooltip)
    {
        $this->withTooltip = (bool) $withTooltip;

        return $this;
    }

    /**
     * Show only the icon and the title as tooltip.
     *
     * @return self
     */
    public function onlyIcon()
    {
        return $this->withIcon(true)->withTooltip(true);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Make link instance.
     *
     * @param  string  $action
     * @param  string  $url
     * @param  array   $attributes
     * @param  bool    $disabled
     *
     * @return self
     */
    public static function make($action, $url, array $attributes = [], $disabled = false)
    {
        return new static($action, $url, $attributes, $disabled);
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml()
    {
        return '<a'.$this->renderAttributes().'>'.$this->renderValue().'</a>';
    }

    /**
     * Get the string content for the link instance.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toHtml();
    }

    /* -----------------------------------------------------------------
     |  Other Functions
     | -----------------------------------------------------------------
     */
    /**
     * Render the link value.
     *
     * @return string
     */
    protected function renderValue()
    {
        if ($this->withTooltip || ! $this->withTitle)
            return $this->renderIcon();

        return $this->withIcon
            ? $this->renderIcon().' '.$this->getActionTitle()
            : $this->getActionTitle();
    }

    /**
     * Render the icon.
     *
     * @return string
     */
    protected function renderIcon()
    {
        return '<i class="'.$this->getLinkIcon().'"></i>';
    }

    /**
     * Render the attributes.
     *
     * @return string
     */
    protected function renderAttributes()
    {
        $attributes = collect();
        $attributes->put('href',  $this->disabled ? 'javascript:void(0);' : $this->url);
        $attributes->put('class', $this->getLinkClass());

        if ($this->withTooltip) {
            // This is for Bootstrap
            $attributes->put('data-toggle', 'tooltip');
            $attributes->put('data-original-title', $this->getActionTitle());
        }

        if ($this->disabled)
            $attributes->put('disabled', 'disabled');

        return html()->attributes($attributes->merge($this->attributes)->toArray());
    }

    /**
     * Get the link class.
     *
     * @return string
     */
    protected function getLinkClass()
    {
        return implode(' ', array_filter(['btn', $this->getLinkSize(), $this->getLinkColor()]));
    }

    /**
     * Get the link color.
     *
     * @return string
     */
    protected function getLinkColor()
    {
        $state = $this->disabled ? 'default' : $this->action;

        return config("arcanesoft.core.ui.links.colors.{$state}");
    }

    /**
     * Get the link size.
     *
     * @return string|null
     */
    protected function getLinkSize()
    {
        return config("arcanesoft.core.ui.links.sizes.{$this->size}");
    }

    /**
     * Get the icon.
     *
     * @return string|null
     */
    protected function getLinkIcon()
    {
        return config("arcanesoft.core.ui.links.icons.{$this->action}");
    }
}