if (window.navigator.userAgent.indexOf("Edge") > -1 || msieversion() == true) {
    alert("Kullanmış olduğunuz tarayıcı bu websayfası için önerilmemektedir. Hatalar ile karşılaşabilirsiniz..")
}

// https://stackoverflow.com/questions/19999388/check-if-user-is-using-ie
function msieversion() {

    let ua = window.navigator.userAgent;
    let msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer, return version number
    {
        return true
        // alert(parseInt(ua.substring(msie + 5, ua.indexOf(".", msie))));
    }
    // else  // If another browser, return 0
    // {
    //     alert('otherbrowser');
    // }
    return false;
}