<?php
class Html
{
    public static function a_is_active($link, $link_name, $classes_array = [])
    {
        if (App::getRouter()->getController() == trim(strtolower($link), '/')) {
            $classes_array[] = 'active';
        }
        $classes = (isset($classes_array)) ? 'class="'.implode(' ', $classes_array).'"' : '';
        $html_a = '<a ' . $classes . ' href="' . REL_URL . '/' . $link . '/'.'" >' . $link_name . '</a>';
        return $html_a;
    }
}