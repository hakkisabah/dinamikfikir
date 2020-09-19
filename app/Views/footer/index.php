<?php
echo '</main>
                           <footer class="text-muted text-center">
                           <div class="container">
                           <p>&copy; 2020</p>
                           <p><a href="' . 'https://github.com/hakkisabah/dinamikfikir' /*$footerIndex['footer']['baseUrl'] */. '">' . 'DinamikFikir' /*$footerIndex['footer']['SITE_NAME']*/ . '</a></p>
                           <p>Developed by <a href="http://www.hakkisabah.com" target="_blank">Hakkı SABAH</a> with <a href="http://codeigniter.com" target="_blank">@CodeIgniter 4.x</a></p>
                           </div>
                           </footer>';
echo $footerIndex['script_tag'];
echo '<!-- Global site tag (gtag.js) - Google Analytics -->
                      <!--  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-171631733-1"></script>-->
               <!--         <script>
                            window.dataLayer = window.dataLayer || [];
                        
                            function gtag() {
                                dataLayer.push(arguments);
                            }
                        
                            gtag(\'js\', new Date());
                        
                            gtag(\'config\', \'UA-171631733-1\')
                        </script>-->
                        
                        <script>
                            function requestDynamic(url,payload,cb) {
                                return axios.post(url, payload)
                                    .then(function (res) {
                                        if (cb){
                                            return cb(res.data)
                                        }else{
                                            return res.data
                                        }
                                    }).catch(function (e) {
                                        return e
                                })
                            }
                        </script>';
?>
<script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js" data-cfasync="false"></script>
<script>
    function lgLogic(lg, num) {
        if (num === 1 && lg == 'tr') {
            alert("<?php echo lang('View.shared.languageSameSelectWarning');  ?>")
            return false
        }
        if (num === 2 && lg == 'en') {
            alert("<?php echo lang('View.shared.languageSameSelectWarning');  ?>")
            return false
        }
        return true

    }

    function removeLangCookie(){
        document.cookie = "df_lang= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
    }
    function setLocale(langId) {
        let isConfirm = confirm("<?php echo lang('View.shared.languageWarning'); ?>")
        if (isConfirm == true) {
            let getCk = '<?php echo get_cookie('df_lang'); ?>';
            if (lgLogic(getCk, langId) == false) {
                return false
            }
            if (langId == 1) {
                // we need one cookie evey time
                removeLangCookie()
                document.cookie = "df_lang=tr;path=/";
            } else {
                // we need one cookie evey time
                removeLangCookie()
                document.cookie = "df_lang=en;path=/";

            }
            location.reload();
        }
    }

    window.cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "#383b75"
            },
            "button": {
                "background": "#f1d600"
            }
        },
        "theme": "classic",
        "content": {
            "message": "<?php echo lang('View.footer.index.cookieContent.message'); ?>",
            "dismiss": "<?php echo lang('View.footer.index.cookieContent.dismiss'); ?>",
            "link": "<?php echo lang('View.footer.index.cookieContent.linkMessage'); ?>",
            "href": "/info/KVKK"
        }
    });
</script>
<?php
if (!empty($footerIndex['uri'][0]) && !empty($footerIndex['uri'][1]) && $footerIndex['uri'][0] == 'admin' && $footerIndex['uri'][1] == 'report') {
    echo view('footer/adminfooter');
}
?>
</body>
</html>