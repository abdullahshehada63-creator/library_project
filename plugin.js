var feild = document.querySelectorAll('.textarea');
// var backUp = feild.getAttribute('placeholder');
var btnn = document.querySelectorAll('.btnn');
var clear = document.getElementById('clear')


Array.from(feild).forEach((ele) => {
    ele.addEventListener('focus', (event) => {
        // this.setAttribute('placeholder', '');
        // this.style.borderColor = '#333';
        ele.nextElementSibling.style.display = 'block';
    })
});


Array.from(feild).forEach((ele) => {
    ele.addEventListener('focusout', (event) => {
        // this.setAttribute('placeholder', '');
        // this.style.borderColor = '#333';
        ele.nextElementSibling.style.display = 'none';
    })
});




feild.onblur = function () {
    this.setAttribute('placeholder', backUp);
    this.style.borderColor = '#aaa'
}

// clear.onclick = function(){
//     btnn.style.display = 'none';
//     feild.value = '';
// }

