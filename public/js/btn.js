const winWidth          = window.innerWidth;
const winHeight         = window.innerHeight;
const myWidth           = document.querySelector("#myWidth");
const myHeight          = document.querySelector("#myHeight");

var myNav               = document.querySelector("nav");
var myCtrl              = document.querySelector("#myMenuHeader>div:last-child");
var myMain              = document.querySelector("body>main");
var myFooter            = document.querySelector("body>footer");

const myShell           = document.querySelector("#shell");
const myReadMe          = document.querySelector("#read_me");
const myInfoClient      = document.querySelector("#infos");
const myDateTimeParty   = document.querySelector("#dateTimeParty");
const myContentClock    = document.getElementById("myClock");

const myPortfolio       = document.querySelector("#portfolio");

const buttonSMS         = document.querySelector("body>section>div>h6");

const btnReadMe         = document.querySelector("nav>ul>li:nth-child(2)");
const btnInfos          = document.querySelector("nav>ul>li:nth-child(3)");
const btnDateTimeParty  = document.querySelector("h1>i");

const btnLeft           = document.querySelector("#myMenuHeader>form>button:first-child");
const btnRight          = document.querySelector("#myMenuHeader>form>button:nth-child(2)");
const btnFull           = document.querySelector("#myMenuHeader>div:last-child>i");


const formCalendar      = document.querySelector("#formCalendar>div>input:last-child");

//      SIZE:
myWidth.innerHTML       = winWidth;
myHeight.innerHTML      = winHeight;


//      SHOW:
btnReadMe.setAttribute('class', 'myDisplayFlex');
btnInfos.setAttribute('class', 'myDisplayFlex');


// NAVBAR SCROLL
// window.onscroll = function() {myFunction()};
// function myFunction() {
//         var myNav = document.querySelector("nav");

//         if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
//                 myNav.className = "myDisplayFlex bgColor2_95 floatingNav"; }
//         else {
//                 myNav.className = myNav.className.replace("myDisplayFlex bgColor2_95 floatingNav", "myDisplayFlex bgColor1_80");
//         }
// }


//      MESSAGE:
function sleepSMS() {buttonSMS.setAttribute('class', 'myDisplayNone');}
setTimeout(sleepSMS, 10000)

buttonSMS.addEventListener('click', {
        handleEvent: function (event) {
                buttonSMS.setAttribute('class', 'myDisplayNone');
        }
});


// BOUTTONS
btnFull.addEventListener('click', {
        handleEvent: function (event) {


                if (myNav.getAttribute('class') === 'myDisplayFlex bgColor1_80') {
                        myNav.setAttribute('class', 'myDisplayNone');
                        myCtrl.setAttribute('class', 'myBgTrsprnt myDisplayFlex');
                        myMain.setAttribute('class', 'myDisplayNone');
                        myFooter.setAttribute('class', 'myDisplayNone');
                }
                else {
                        myNav.setAttribute('class', 'myDisplayFlex bgColor1_80');
                        myCtrl.setAttribute('class', 'myDisplayFlex bgColor1_15');
                        myMain.setAttribute('class', 'myDisplayFlex');
                        myFooter.setAttribute('class', 'myDisplayFlex bgColor1_80');}}}
);

btnReadMe.addEventListener('click', {
        handleEvent: function (event) {
                if (myReadMe.getAttribute('class') !== 'myDisplayFlex') {
                        myShell.setAttribute('class', 'myShell myDisplayFlex');
                        myInfoClient.setAttribute('class', 'myDisplayNone');
                        myReadMe.setAttribute('class', 'myDisplayFlex');
                        myDateTimeParty.setAttribute('class', 'myDisplayNone');
                }
                else {
                        if (myInfoClient.getAttribute('class') !== 'myDisplayFlex') {
                                myShell.setAttribute('class', 'myDisplayNone');
                                myInfoClient.setAttribute('class', 'myDisplayNone');
                        }
                        if (myDateTimeParty.getAttribute('class') !== 'myDisplayFlex') {
                                myShell.setAttribute('class', 'myDisplayNone');
                                myDateTimeParty.setAttribute('class', 'myDisplayNone');
                        }
                        myReadMe.setAttribute('class', 'myDisplayNone');
                }
        }
});

btnInfos.addEventListener('click', {
        handleEvent: function (event) {
                if (myInfoClient.getAttribute('class') !== 'myDisplayFlex') {
                        myShell.setAttribute('class', 'myShell myDisplayFlex');
                        myInfoClient.setAttribute('class', 'myDisplayFlex');
                        myReadMe.setAttribute('class', 'myDisplayNone');
                        myDateTimeParty.setAttribute('class', 'myDisplayNone');
                }
                else {
                        if (myReadMe.getAttribute('class') !== 'myDisplayFlex') {
                                myShell.setAttribute('class', 'myDisplayNone');
                                myReadMe.setAttribute('class', 'myDisplayNone');
                        }
                        if (myDateTimeParty.getAttribute('class') !== 'myDisplayFlex') {
                                myShell.setAttribute('class', 'myDisplayNone');
                                myDateTimeParty.setAttribute('class', 'myDisplayNone');
                        }
                        myInfoClient.setAttribute('class', 'myDisplayNone');
                }
        }
});

btnDateTimeParty.addEventListener('click', {
        handleEvent: function (event) {
                if (myDateTimeParty.getAttribute('class') !== 'myDisplayFlex') {
                        myShell.setAttribute('class', 'myShell myDisplayFlex');
                        myDateTimeParty.setAttribute('class', 'myDisplayFlex');
                        myReadMe.setAttribute('class', 'myDisplayNone');
                        myInfoClient.setAttribute('class', 'myDisplayNone');
                }
                else {
                        if (myReadMe.getAttribute('class') !== 'myDisplayFlex') {
                                myShell.setAttribute('class', 'myDisplayNone');
                                myReadMe.setAttribute('class', 'myDisplayNone');
                        }
                        if (myInfoClient.getAttribute('class') !== 'myDisplayFlex') {
                                myShell.setAttribute('class', 'myDisplayNone');
                                myInfoClient.setAttribute('class', 'myDisplayNone');
                        }
                        myDateTimeParty.setAttribute('class', 'myDisplayNone');
                }
        }
});

function sendData(data) {
        const myMenuHeaderForm = document.querySelector("#myMenuHeader>form");
        const myNamePicture = document.querySelector("#myMenuHeader>div>span");
        const myHiddenInput = document.querySelector("#myMenuHeader>form>input");
        const Form = new FormData(myMenuHeaderForm);

        const params = new URLSearchParams();
        Form.forEach((value, key) => {
                params.append(key, value);
        })
        params.append('direction', data[0]);

        let myInit = {
                method: 'GET',
                headers: {"X-Requested-With" : "XMLHttpRequest"}
        };
        
        fetch("/bg?" + params.toString(), myInit)
                .then(response =>
                        response.json())
                .then(data => {
                        let myPath = "/design/img/bg/webP/" + data.bg;
                        myHiddenInput.value = data.bg;
                        myNamePicture.innerHTML = data.bg;
                        document.body.style.background = "center fixed url('" + myPath + "')";
        })
}

btnLeft.addEventListener('click', {
        handleEvent: function (event) {
                let data = ['last'];

                sendData(data);
}});

btnRight.addEventListener('click', {
        handleEvent: function (event) {
                let data = ['next'];

                sendData(data);
}});