(function(a){inlineEditMembership={init:function(){a("a.editmembership").live("click",function(){inlineEditMembership.edit(this);return!1});a(".submit a.cancel").live("click",function(){var b=a(this).parents("tr:first"),c=inlineEditMembership.getId(b[0]);b.remove();a("#user-"+c).css("display","table-row")});a(".submit a.save").live("click",function(){var b=a(this).parents("tr:first");inlineEditMembership.save(b[0])});a('input[name="membership_permanent"]').live("click",function(){a(this).filter(":checked").length>
0?a(this).parents("fieldset:first").find(".inline-edit-date").find("input, select").removeAttr("disabled").prop("disabled",!1):a(this).parents("fieldset:first").find(".inline-edit-date").find("input, select").attr("disabled","disabled").prop("disabled","disabled")});a("#grouptable .row-actions .trash").click(function(){return confirm(ctxpsmsg.RemoveUser)})},edit:function(b){var c,d,e=!1;inlineEditMembership.revert();typeof b=="object"&&(b=inlineEditMembership.getId(b));c=a("#inline_"+b);d=a("#inline-edit").clone().attr("id",
"edit-"+b).prop("id","edit-"+b).insertAfter("#user-"+b).css("display","table-row");a(".username",d).text(a(".username",c).text());a(".jj",c).text().length!=0&&(a('input[name="membership_permanent"]',d).attr("checked","checked").prop("checked","checked"),e=!0);e&&d.find(".inline-edit-date").find("input, select").removeAttr("disabled").prop("disabled",!1).filter('[name="mm"]').val(a(".mm",c).text()).end().filter('[name="aa"]').val(a(".aa",c).text()).end().filter('[name="jj"]').val(a(".jj",c).text()).end();
a("#user-"+b).hide()},save:function(b){var c,d,e,g,f,h,j="",i=0;a(".inline-edit-save .waiting").show();b=inlineEditMembership.getId(b);h=a("#inline_"+b);f=a("#edit-"+b);c=h.find(".grel").text();d=f.find('select[name="mm"]').val();e=f.find('input[name="jj"]').val();g=f.find('input[name="aa"]').val();if(f.find('[name="membership_permanent"]:checked').length!=0){i=1;e==""&&(e=1);if(g=="")return a(".inline-edit-save .waiting").hide(),alert(ctxpsmsg.YearRequired),!1;j=g+"-"+d+"-"+e}else g=e=d="";a.post("admin-ajax.php",
{action:"ctxps_update_member",grel:c,expires:i,date:j},function(c){var c=a(c),f="Never";c.find("update").attr("id")=="1"?(i==1&&(f=d+"-"+e+"-"+g,new Date(f)<new Date&&(f="Expired")),a("#user-"+b).find(".column-expires").text(f),h.find(".jj").text(e),h.find(".mm").text(d),h.find(".aa").text(g),inlineEditMembership.revert(),a("#user-"+b).animate({"background-color":"#e0ffe3"},250,function(){a(this).animate({"background-color":"#ffffff"},1E3)})):(a(".inline-edit-save .waiting").hide(),alert(ctxpsmsg.GeneralError+
c.find("wp_error").text()))},"xml")},revert:function(){a("tr.inline-edit-row:visible").each(function(){var b=inlineEditMembership.getId(a(this)[0]);a(this).remove();a("#user-"+b).css("display","table-row")});a(".inline-edit-save .waiting").hide()},getId:function(b){b=(b.tagName=="TR"?b.id:a(b).parents("tr:first").attr("id")).split("-");return b[b.length-1]}};a(document).ready(function(){inlineEditMembership.init()})})(jQuery);