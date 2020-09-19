<script type="application/ld+json">
    <?php
    $titleComma ='';
    if (!empty($header['content_images']) && count($header['content_images']) > 0 && empty($header['content_images'][0])){
        $titleComma ='"';
    }else{
        $titleComma ='",';
    }
    if (!empty($header)) {
        echo '{
        "@context": "https://schema.org",
        "@type": "Article",
      "mainEntityOfPage": {
        "@type": "Blog",
        "@id": "' . current_url() . '"
      },
      "headline": "' . $header['content_title'] . '",
      "image": [
      "' . $header['currentImagePathForSEO'] . $header['content_title_image'] . $titleComma."\n";
        if (!empty($header['content_images'])) {
            $total = count($header['content_images']) - 1;
            foreach ($header['content_images'] as $key => $value) {
                // Buradaki tanımda son resimden sonra virgül olmaması gereklidir o yüzden
                // son elemanı tespit etmek için $comma değişkeninde mantıksal sorgulama yaparak virgül atıyoruz
                $comma = $total != $key?',':'';
                if (!empty($value)){
                    echo '"' . $header['currentImagePathForSEO'] . $value . '"'. $comma ."\n";
                }

            }
        }
        echo '],
      "datePublished": "'. date(DATE_ISO8601,strtotime($header['content_date']['createdAt'])) .'",
      "dateModified": "'. date(DATE_ISO8601,strtotime($header['content_date']['updatedAt'])) .'",
      "author": {
        "@type": "Person",
        "name": "'. $header['content_owner_full_name'] .'"
      },
       "publisher": {
        "@type": "Organization",
        "name": "' . getenv('SITE_NAME') .'",
        "logo": {
            "@type": "ImageObject",
          "url": "' . base_url() . '/public/assets/logo/logo.png"
        }
      }
    }';
    }
    ?>

</script>