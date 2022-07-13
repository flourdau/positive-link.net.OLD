//  MY ANCRE

function myAncre() {
        var ancre = window.location.hash.replace('#','');

        if (ancre === "read_me") {
                myShell.setAttribute('class', 'myShell');
                myReadMe.setAttribute('class', 'myDisplayFlex');
                myInfoClient.setAttribute('class', 'myDisplayNone');
                myDateTimeParty.setAttribute('class', 'myDisplayNone');
        }
        else if (ancre === "infos") {
                myShell.setAttribute('class', 'myShell');
                myReadMe.setAttribute('class', 'myDisplayNone');
                myInfoClient.setAttribute('class', 'myDisplayFlex');
                myDateTimeParty.setAttribute('class', 'myDisplayNone');
        }
        else if (window.location.pathname != '/portfolio' && formCalendar.value == 0){
                formCalendar.value = 1;
                myShell.setAttribute('class', 'myDisplayNone');
                myReadMe.setAttribute('class', 'myDisplayNone');
                myInfoClient.setAttribute('class', 'myDisplayNone');
                myDateTimeParty.setAttribute('class', 'myDisplayNone');
        }
        else if (window.location.pathname == '/portfolio') {
                return;
        }
        else {
                myShell.setAttribute('class', 'myShell myDisplayFlex');
                myDateTimeParty.setAttribute('class', 'myDisplayFlex');
                myReadMe.setAttribute('class', 'myDisplayNone');
                myInfoClient.setAttribute('class', 'myDisplayNone');
        }
}

myAncre();