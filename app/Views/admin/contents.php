<div class="row">
    <?php if (session()->get('success')): ?>
        <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
        </div>
    <?php endif; ?>

    <div class="col-lg-6 mt-3 pt-3 pb-3 form-wrapper">
        <div class="container">
            <?php
            echo view('admin/content/content_search', $data = []);
            ?>
        </div>
    </div>
    <div class="col-lg-6 mt-3 pt-3 pb-3 form-wrapper">
        <div class="container">
            <?php
            echo view('admin/content/content_detail', $data = []);
            ?>
        </div>
    </div>
</div>
<script>
    forms = {}

    let searchedContent = []

    let myContentList = document.getElementById("myContentList")
    let contentDetailForm = document.getElementById('contentConf')
    let titleInput = document.getElementById('title');

    let contentDeleteButton = document.getElementById('contentDeleteButton')
    let contentShowButton = document.getElementById('contentShowButton')
    let usertShowButton = document.getElementById('usertShowButton')

    let userIconElement = document.getElementById('userIcon')
    let userIconHiddenElement = document.getElementById('icon_name')

    let searchContent = document.getElementById('searchcontent')



    searchContent.addEventListener('keydown', function (e) {
        if (e.key == 'Enter') {
            e.preventDefault();
            return false;
        }
    })


    function getContent(e) {

        myContentList.innerHTML = ''
        contentDeleteButton.disabled = false
        contentShowButton.disabled = false
        usertShowButton.disabled = false
        Object.keys(searchedContent[e.value]).forEach(key => {
            let liNode = document.getElementsByName(key)
            if (liNode.length != 0) {
                contentDetailForm.elements.namedItem(key).setAttribute('value', searchedContent[e.value][key])
            }
        })
        userIconElement.src = '<?php echo $admin_contents_data['currentBase']; ?>' + '/public/assets/svg/UserIcon/' + userIconHiddenElement.value
        userIconElement.setAttribute('class',userIconElement.getAttribute('class').replace('',' show '))
        searchContent.value = e.textContent

        searchedContent = {}

    }


    function contentGetter(res) {

        myContentList.innerHTML = ''
        if (res.content !== false) {
            searchedContent = res.content
            Object.keys(searchedContent).forEach(key => {
                let node = document.createElement("LI")
                let textnode = document.createTextNode(searchedContent[key].title)
                node.setAttribute('class', 'list-group-item')
                node.setAttribute('onclick', 'getContent(this)')
                node.setAttribute('value', key)
                node.appendChild(textnode)
                myContentList.appendChild(node);
            })
        }
    }

    function contentDetailProcess(e) {
        if (e.id == 'contentDeleteButton') {
            let contentConfirm = confirm("<?php echo lang('View.AdminPanel.content.script.confirmContentDelete'); ?>")
            if (contentConfirm == true) {
                requestDynamic('/admin/deletecontent', 'deleteContentWithSlug=' +document.getElementById('slug').value)
                    .then(function (res) {
                        alert('<?php echo lang('View.AdminPanel.content.script.contentDeleted'); ?>')
                        contentDetailResetter()
                    }).catch(function (e) {
                    console.log(e)
                })
            }
        }
        if (e.id == 'contentShowButton') {
            window.open('/content/' + document.getElementById('slug').value, '_blank')
        }
        if (e.id == 'usertShowButton') {
            window.open('/profile/' + document.getElementById('user_name').value, '_blank')
        }
    }

    function contentDetailResetter() {

        contentDetailForm.reset()
        contentDeleteButton.disabled = true
        contentShowButton.disabled = true
        usertShowButton.disabled = true
        userIconElement.setAttribute('class',userIconElement.getAttribute('class').replace(' show ',''))
        setTimeout(function (){
            // hata vermemesi için
            userIconElement.src = ''
        },500)
        titleInput.setAttribute('value','')
        myContentList.innerHTML = ''
    }


    function contentSearcher(e) {
        if (e.value) {
            let formData = new FormData();
            formData.append('searchcontent', e.value)
            if (e.value != '') {
                requestDynamic('/admin/searchcontent', formData)
                    .then(function (res) {
                        contentGetter(res)
                    }).catch(function (e) {
                    console.log(e)
                })
            }
        } else {
            contentDetailResetter()
        }

    }

    function formCollector(element) {
        forms[element.name] = element.value
    }
</script>