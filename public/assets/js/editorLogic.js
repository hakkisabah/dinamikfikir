
// detectAndChangeIfBaseLinkChanged()

// Eğer herhangi bir durumda lokasyon değişirkne görsel kaynaklarında bir problem gelişmişse
// buradaki fonksiyon devreye girecektir..

function detectAndChangeIfBaseLinkChanged() {
    let httpOrHttps = 'http://'
    let savedContentImages = []
    let qleditorChildLength = quill.container.children.length
    if (qleditorChildLength > 0) {
        for (let i = 0; i < qleditorChildLength; i++) {
            if (quill.container.children[i].className == 'ql-editor') {
                let tag = quill.container.children[i].children
                if (tag.length > 0) {
                    for (let j = 0; j < tag.length; j++) {
                        let paragraph = tag[j].childNodes
                        if (paragraph.length > 1) {
                            for (let k = 0; k < paragraph.length; k++) {
                                if (paragraph[k].tagName === 'IMG' && paragraph[k].src) {
                                    if (paragraph[k].src.split('/')[2] !== currentBase().split('/')[2]) {
                                        // currentBase().split('/')[2]
                                        let currentItemLink = httpOrHttps + currentBase().split('/')[2] +
                                            '/' +
                                            paragraph[k].src.split('/')[3] +
                                            '/' +
                                            paragraph[k].src.split('/')[4] +
                                            '/' +
                                            paragraph[k].src.split('/')[5] +
                                            '/' +
                                            paragraph[k].src.split('/')[6]
                                        paragraph[k].setAttribute('src', currentItemLink)
                                        savedContentImages.push(paragraph[k].src.split('/')[6])
                                    }
                                }
                            }
                        } else {
                            if (paragraph[0].src) {
                                if (paragraph[0].src.split('/')[2] !== currentBase().split('/')[2]) {
                                    let currentItemLink = httpOrHttps + currentBase().split('/')[2] +
                                        '/' +
                                        paragraph[0].src.split('/')[3] +
                                        '/' +
                                        paragraph[0].src.split('/')[4] +
                                        '/' +
                                        paragraph[0].src.split('/')[5] +
                                        '/' +
                                        paragraph[0].src.split('/')[6]

                                    paragraph[0].setAttribute('src', currentItemLink)
                                    savedContentImages.push(paragraph[0].src.split('/')[6])
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (savedContentImages.length > 0) {
        // if you writing anything..
    }
}
