function loadForUpdate() {
    // Sayfa yüklendiğinde düzenleme için açılıyorsa içeriğin başlık resmi sorgulanır
    // sorgu sonucunda karakter sayısı 0 dan büyükse bir görüntü olduğu anlaşılır.
    // ve görüntülenmesine izin verilir.
    if (tempFile.getAttribute('src').length > 0) {
        tempFile.setAttribute('style', 'display : block;')
    }
    let hiddenEditLocal = document.getElementById("contentHiddenForDiv")
    let editorLocal = document.getElementById("editor").innerHTML
    hiddenEditLocal.value = editorLocal;
}

function extensionChecker(file) {
    if (file) {
        if (file && file.size > 1048576) {
            alert("Dosya boyutu en fazla 1 megabyte olabilir. Giriş yapılan içeriğin kaybolmaması için lütfen tekrar geçerli bir yükleme seçiniz.");
            this.value = "";
            return false;
        } else {
            let filename = file.name
            filename = filename.split('.').pop()
            if (filename == 'jpg' || filename == 'jpeg' || filename == 'png') {
                return true
            } else {
                return 'notValid';
            }
        }

    } else {
        return false
    }
}

function transferring() {
    isLeaveWithClick = 1
    let temp = document.getElementsByClassName("ql-editor")[0].innerHTML
    hiddenEdit.value = temp
    contentCalc.value = quill.getText()
}


function removeSingleTempImage(FullName) {
    if (FullName) {
        requestDynamic('/dashboard/removesingletempimage', 'removeSingleTemp=' + FullName)
            .then(function (res) {
                // console.log(res)
            }).catch(function (e) {
            // console.log(e)
        })
    } else {
        alert("Error")
    }
}

function imageHandler() {
    let tempThis = this
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();
    input.onchange = function () {
        const file = input.files[0];
        let formDataTemp = new FormData()
        formDataTemp.append('editorImage', file)
        requestDynamic('/dashboard/uploadimage', formDataTemp)
            .then(function (res) {
                spinnerField.setAttribute('style', 'display : none;')
                // console.log(res)
                const imageNames = res.imageLink.editor;
                let range = tempThis.quill.getSelection();
                // Gelen editor cevabı bir dizi olduğu için bu dizinin her zaman en sonundaki eleman alınıp eklenmesi gerekir..
                // Son elemana imageNames[imageNames.length -1] koduyla basit bir şekilde erişebiliyoruz
                // editorImages değişkeni kayıt işlemi tetiklendikten sonra karşılaştırma yapabileceğimiz gizli bir input elemanı

                readyEditorImagesArray.push(imageNames[imageNames.length - 1])
                editorImages.value = readyEditorImagesArray

                // editorde görünteleme işlemi..
                tempThis.quill.insertEmbed(range.index, 'image', res.imageLink.baseLink + imageNames[imageNames.length - 1]);
                // console.log(res)
            }).catch(function (e) {
            spinnerField.setAttribute('style', 'display : none;')
            // console.log(e)
        })

    }
}