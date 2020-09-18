let uploadField = document.getElementById("titleImage");
let tempFile = document.querySelector("#tempImageDiv")
let reader = new FileReader();
let spinnerField = document.querySelector('#spinnerField')
// transferring fonksiyonunda çalışacak değişkenler..
let hiddenEdit = document.getElementById("contentHiddenForDiv");
let contentCalc = document.getElementById("contentCalculator");
let editorImages = document.getElementById('editorImagesHidden')
let readyEditorImagesArray = editorImages.value?editorImages.value.toString().split(','):Array()
const toolbarOptions = [
    [{'header': 1}, {'header': 2}],
    ['bold', 'italic', 'underline', 'link'], // toggled buttons
    ['code-block'],
    [{'list': 'ordered'}, {'list': 'bullet'}],
    [{'size': ['small', false, 'large', 'huge']}],
    [{'header': [1, 2, 3, 4, 5, 6, false]}],
    [{'font': []}],
    [{'align': []}],

    ['clean'],                                         // remove formatting button
    ['image'],
    ['video']
];
let quill = new Quill('#editor', {
    modules: {
        toolbar: {
            container: toolbarOptions,
            handlers: {
                image: imageHandler
            }
        },
        history: {
            delay: 2000,
            maxStack: 500,
            userOnly: true
        }

    },
    theme: 'snow'
});