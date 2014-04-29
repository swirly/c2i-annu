<!-- javascript inclusion -->

<script type="text/javascript" src="include/js/jquery.min.js"></script>
<script type="text/javascript" src="include/js/bootstrap.js"></script>

{literal}
<script language="javascript">
function checkAll(myform) {
  for (var i=0;i < myform.elements.length;i++) {
    if (myform.elements[i].type=="checkbox") {
      myform.elements[i].checked=true;
    }
  }
}
function unCheckAll(myform) {
  for (var i=0;i < myform.elements.length;i++) {
    if (myform.elements[i].type=="checkbox") {
      myform.elements[i].checked=false;
    }
  }
}
</script>
{/literal}

<div style="min-height:50px;">
</div>
</body>
</html>