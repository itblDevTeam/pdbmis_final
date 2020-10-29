const openNav = () => {
  document.getElementById("mySidenav").style.width = "218px";
  // document.getElementById('mainpart').style.top = '500px';
  document.getElementById("mainpart").style.left = "218px";
  document.getElementById("tophead").style.left = "218px";
  document.getElementById("bar").style.display = "none";

  // document.getElementById('mainpart').style.rigth = '250px';

  // document.getElementById('tophead').style.color = "red";
  // document.getElementById('tophead').style.width = '500px';
  // document.getElementById('tophead').style.top = '250px';
};

const closeNav = () => {
  document.getElementById("mySidenav").style.width = "0px";
  // document.getElementById('mainpart').style.top = '65px';
  document.getElementById("mainpart").style.left = "0px";
  document.getElementById("tophead").style.left = "0px";
  document.getElementById("bar").style.display = "flex";
  // document.getElementById('mainpart').style.right = '0px';
  // document.getElementById('tophead').style.left = '0px';
};


// sidebar transition for small device starts
function myFunction(x) {
    if (x.matches) { // If media query matches
        const openNav = () => {
            document.getElementById("mySidenav").style.width = "120px";
            // document.getElementById('mainpart').style.top = '500px';
            document.getElementById("mainpart").style.left = "120px";
            document.getElementById("tophead").style.left = "120px";
            document.getElementById("bar").style.display = "none";
          
            // document.getElementById('mainpart').style.rigth = '250px';
          
            // document.getElementById('tophead').style.color = "red";
            // document.getElementById('tophead').style.width = '500px';
            // document.getElementById('tophead').style.top = '250px';
          };
    } else {
        const openNav = () => {
            document.getElementById("mySidenav").style.width = "200px";
            // document.getElementById('mainpart').style.top = '500px';
            document.getElementById("mainpart").style.left = "200px";
            document.getElementById("tophead").style.left = "200px";
            document.getElementById("bar").style.display = "none";
          
            // document.getElementById('mainpart').style.rigth = '250px';
          
            // document.getElementById('tophead').style.color = "red";
            // document.getElementById('tophead').style.width = '500px';
            // document.getElementById('tophead').style.top = '250px';
          };
    }
  }
  
var x = window.matchMedia("(max-width: 780px)")
myFunction(x) // Call listener function at run time
x.addListener(myFunction) // Attach listener function on state changes
// x.addEventListener("click",myFunction) // Attach listener function on state changes
// sidebar transition for small device ends
