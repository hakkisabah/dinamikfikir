// Editorde görsel silindiğinde geçici lokasyondan ve hafızadan silen kod bloğu
// aynı zamanda bunu gizli inputa kaydeder ve sunucu tarafında da mantıksal sorgulama yapılır.
quill.on("text-change", (delta, oldDelta, source) => {
    if (source === "user") {
        let currrentContents = quill.getContents();
        let diff = currrentContents.diff(oldDelta);
        try {
            if (diff.ops[1].insert.image) {
                let img = diff.ops[1].insert.image
                let deletingImageName = img.split('/')[img.split('/').length - 1]
                let checkingIsTempImage = editorImages.value.toString().search(deletingImageName)
                // Eğer silinen içerik görseli yeni yüklenmiş ise bu editorImages.value değerinde varolacağı için
                // sadece kaydedilmemiş görselleri geçici klasore doğru silme isteği göndermemizi sağlar.
                // isLeaveWithClick değişkeni mutlaka sorgulanmalı.. sorgulanmadığı takdirde içeriği kaydederken text-change tetiklenir
                // ve içerikteki resim rastgele silinmiş olur..
                if (checkingIsTempImage != -1 && isLeaveWithClick !== 1) {

                    readyEditorImagesArray.splice(readyEditorImagesArray.indexOf(deletingImageName), 1)
                    editorImages.setAttribute('value', readyEditorImagesArray.join(','))
                    removeSingleTempImage(deletingImageName);

                }
            }
        } catch (_error) {
        }
    }
});
uploadField.onchange = function () {
    // Kullanıcı resim yükleme penceresinde iptal butonuna basarsa hata vermemesi için aşağıdaki koşul yazıldı
    let extensionResultHere = extensionChecker(this.files[0])
    if (extensionResultHere != 'notValid') {
        if (this.files && this.files[0]) {
            reader.onload = function (e) {
                tempFile.setAttribute('src', e.target.result);
                tempFile.setAttribute('style', 'display : block;')
            }
            reader.readAsDataURL(this.files[0]);
            let hiddenImage = document.getElementById("imageHiddenForTitleImage")
            hiddenImage.files = this.files
            let formDataTemp = new FormData()
            formDataTemp.append('titleImage', hiddenImage.files[0])
            spinnerField.setAttribute('style', 'display : block;')
            requestDynamic('/dashboard/uploadimage', formDataTemp)
                .then(function (res) {
                    spinnerField.setAttribute('style', 'display : none;')
                }).catch(function (e) {
                spinnerField.setAttribute('style', 'display : none;')
                alert("Burası" + e);
            })
        }
    } else if (extensionResultHere == 'notValid') {
        alert(errorCallBack('imageExtension'));
    }
}
// Editor sayfasından yükleme haricinde ayrılanları tespit etmek için bu değişkene değer atanıyor.
// değişkene değer atayan fonksiyon transferring()
let isLeaveWithClick = 0;
window.onunload = function (e) {
    // Burada da eğer kullanıcı kaydet demeden çıktıysa geçici resim hafızadan ve lokasyondan silinir..
    if (isLeaveWithClick !== 1) {
        requestDynamic('/dashboard/userleaveremovetempimage', {leave: 'ok'})
    }
}