{literal}
    <script>document.cookie='resolution='+Math.max(screen.width,screen.height)+'; path=/';</script>
    <script type="text/javascript">
        var url_root = '{/literal}{$PG_URL_HOMEPAGE}{literal}';
        var page = '{/literal}{$page}{literal}';
        var nameCompay = '{/literal}{if $setting.setting_company}{$setting.setting_company}{else}{$setting.setting_only_title_web}{/if}{literal}';
        var nameDomain = '{/literal}{$setting.setting_domain}{literal}';
        var gaId = '{/literal}{$setting.setting_ga_id}{literal}';
        var googletagmanagerId = '{/literal}{$setting.setting_google_tag_manager}{literal}';
        var settingDomainAllow = {/literal}{if $setting.setting_domain_exclude_json}{$setting.setting_domain_exclude_json}{else}''{/if}{literal};
        var settingSite = {/literal}{if $setting.setting_site_json}{$setting.setting_site_json}{else}''{/if}{literal};
    </script>
{/literal}
<script async src="https://www.googletagmanager.com/gtag/js?id={$setting.setting_ga_id}"></script>
{literal}
    <script>
        if ( gaId ) {
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', gaId);
        }
    </script>
{/literal}
{literal}
    <script>
        if ( googletagmanagerId ) {
            (function (w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(), event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', googletagmanagerId);
        }
    </script>
    <script type="application/ld+json">
        {/literal}{$schema_application_json}{literal}
    </script>
    <script type="application/ld+json">
        {/literal}{$schema_application_json_user}{literal}
    </script>
{/literal}
{if $setting.setting_data_schema == 2 || $setting.setting_data_schema == '2'}
    {literal}
        <script type="application/ld+json">
            {/literal}{$schema_webpage_json}{literal}
        </script>
        <script type="application/ld+json">
            {/literal}{$schema_organization_json}{literal}
        </script>
        <script type="application/ld+json">
            {/literal}{$schema_faq_json}{literal}
        </script>
    {/literal}
{/if}
{if $setting.setting_yandex_metrica_id}
    <!-- Yandex.Metrika counter -->
    {literal}
    <script type="text/javascript" >
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function() {
                try {
                    w.yaCounter{/literal}{$setting.setting_yandex_metrica_id}{literal} = new Ya.Metrika({
                        id:{/literal}{$setting.setting_yandex_metrica_id}{literal},
                        clickmap:true,
                        trackLinks:true,
                        accurateTrackBounce:true,
                        webvisor:true,
                        trackHash:true,
                        ecommerce:"dataLayer"
                    });
                } catch(e) { }
            });

            var n = d.getElementsByTagName("script")[0],
                    s = d.createElement("script"),
                    f = function () { n.parentNode.insertBefore(s, n); };
            s.type = "text/javascript";
            s.async = true;
            s.src = "https://mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else { f(); }
        })(document, window, "yandex_metrika_callbacks");
    </script>
    {/literal}
    <noscript><div><img src="https://mc.yandex.ru/watch/{$setting.setting_yandex_metrica_id}" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->
{/if}
{if $setting.setting_ads_facebook_code}
    {$setting.setting_ads_facebook_code}
{/if}
{if $setting.setting_mobile_crm}
    <iframe src='{$setting.setting_mobile_crm}' style='display:none;'></iframe>
{/if}