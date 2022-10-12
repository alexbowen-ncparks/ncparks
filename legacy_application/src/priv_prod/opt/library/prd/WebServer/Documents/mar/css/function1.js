function popitup(url)
{
        newwindow=window.open(url,'name','height=450,width=650');
        if (window.focus) {newwindow.focus()}
        return false;
}

function newWindow1(file,window) {
    msgWindow=open(file,window,"resizable=yes,width=800,height=650");
    if (msgWindow.opener == null) msgWindow.opener = self;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
