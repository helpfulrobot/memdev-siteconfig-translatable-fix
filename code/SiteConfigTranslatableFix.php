<?php

/**
 * Copyright 2016 memdev.
 * http://www.memdev.de
 *
 * This piece of code is provided "as is", without any guarantee.
 * Use at your own risk.
 *
 * License: BSD-3-Clause
 */
class SiteConfigTranslatableFix extends Extension
{

    public function updateEditForm(Form $form)
    {
        $locale = isset($_REQUEST['locale']) ? $_REQUEST['locale'] : $_REQUEST['Locale'];
        if (!empty($locale)
            && i18n::validate_locale($locale)
            && singleton('SiteConfig')->has_extension('Translatable')
            && (
                Translatable::get_allowed_locales() === null
                || in_array($locale, (array)Translatable::get_allowed_locales(), false)
            )
            && $locale != Translatable::get_current_locale()
        ) {
            $orig = Translatable::get_current_locale();
            Translatable::set_current_locale($locale);
            $formAction = $form->FormAction();
            $form->setFormAction($formAction);
            Translatable::set_current_locale($orig);
        }
    }

}
