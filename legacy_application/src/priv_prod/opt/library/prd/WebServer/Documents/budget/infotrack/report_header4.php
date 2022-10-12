<?php

echo "<style type='text/css'>

#coolMenu,
#coolMenu ul {
    list-style: none;
}
#coolMenu {
    float: left;
}
#coolMenu > li {
    float: left;
}
#coolMenu li a {
display: block;
    height: 2em;
    line-height: 2em;
    padding: 0 1.5em;
    text-decoration: none;
}
#coolMenu ul {
    position: absolute;
    display: none;
z-index: 999;
}
#coolMenu ul li a {
    width: 100px;
}
#coolMenu li:hover ul {
    display: block;
}

#coolMenu {
    font-family: Arial;
    font-size: 12px;
    background: #2f8be8;
}
#coolMenu > li > a {
    color: #fff;
    font-weight: bold;
}
#coolMenu > li:hover > a {
    background: #f09d28;
    color: #000;
}
 
/* Submenu
------------------------------------------*/
#coolMenu ul {
    background: #f09d28;
}
#coolMenu ul li a {
    color: #000;
}
#coolMenu ul li:hover a {
    background: #ffc97c;
}
</style>";




?>