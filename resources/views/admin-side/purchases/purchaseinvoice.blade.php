<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Basic Business Transactions - Add Purchase Invoice</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Basic Business Transactions - Add Purchase Invoice" />
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <!-- The styles -->


  <style>
    .small {
      padding: 0px 5px;
    }

    #tbody input[type="text"] {
      width: 50px;
      border-radius: 3px;
      border: 1px solid #cccccc;
      text-align: center;
    }

    #tbody>tr>td,
    #tfoot>tr>td {
      padding: 4px 8px;
    }

    #tfoot>tr>td {
      border: 40px;
    }

    #tfoot .total {
      font-weight: bold;
      font-size: 16px;
    }

    #tfoot .total-val {
      font-weight: bold;
      font-size: 16px;
      padding-left: 10px;
    }

    #tfoot .prebal,
    #tfoot .prebal-val {
      font-weight: bold;
      font-size: 16px;
      border-bottom: double 3px #dddddd;
    }

    #tfoot .prebal-val {
      padding-left: 10px;
    }

    #tfoot .discount {
      font-size: 16px;
    }

    #tfoot .discount-td,
    #tfoot .discount {
      font-weight: bold;
      border-bottom: double 3px #dddddd;
    }

    #tfoot .discount-val {
      padding: 7px 0px;
      font-size: 16px;
    }

    .table-hover>thead>tr>th,
    .table>tbody>tr>td {
      padding: 5px 8px 5px 8px;
    }

    /*for chosen.js required attribute validation*/
    .action-btn {
      color: #333;
    }

    /* select:invalid {
      height: 0px !important;
      opacity: 0 !important;
      position: absolute !important;
      display: flex !important;
    }

    select:invalid[multiple] {
      margin-top: 15px !important;
    } */
    select {
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
    -webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
}
    .bold {
      font-weight: bold;
    }
  </style>
</head>

<body>

  <style>
    li ul li {
      font-size: 12px;
    }
  </style>
  <div class="ch-container">
    <div class="row">
      <!-- left menu starts -->
      <div class="col-sm-2 col-lg-2">

      </div>
      <!--/span-->
      <!-- left menu ends -->

      <script type="text/javascript">
        var invoiceItems = {};
        var count = 1;
        var update_check = 0;
        var select_check = 0;

        function quantity(pid) {
          if ($("#qty_" + pid).val() == 0 || $("#qty_" + pid).val() == "")
            $("#qty_" + pid).val("1");
          editTotal(pid);
        }
        function editTotal(pid) {
          var t = fixdecimal(
            $("#pprice_" + pid).val() * $("#qty_" + pid).val()
          );
          $("#ftotal_" + pid).val(t);
          $("#total_" + pid).html(t);

          if (!$("#pprice_" + pid).val() || !$("#qty_" + pid).val()) {
            $("#fnet_" + pid).val("");
            $("#net_" + pid).html("");
          }
          var dis = $("#dis_" + pid).val();
          if (dis > 0) editNet(pid, event);
          if (dis == 0) editNet_disval(pid, event);
          invoice_total();
        }

        function editNet(pid, event) {
          var dis = $("#dis_" + pid).val();
          var total_amount = $("#ftotal_" + pid).val();
          if (total_amount > 0 && event.which != 9 && event.which != 16) {
            var net_amount = fixdecimal(
              total_amount - (total_amount * dis) / 100
            );
            $("#disval_" + pid).val(fixdecimal(total_amount - net_amount));
            $("#fnet_" + pid).val(net_amount);
            $("#net_" + pid).html(net_amount);
            //for invoice total
            invoice_total();
            //invoice total end
          }
        }
        function editNet_disval(pid, event) {
          var dis = $("#disval_" + pid).val();
          var total_amount = $("#ftotal_" + pid).val();
          if (total_amount > 0) {
            var net_amount = fixdecimal(total_amount - dis);
            $("#fnet_" + pid).val(net_amount);
            $("#net_" + pid).html(net_amount);

            if (
              event.which == 46 ||
              event.which == 190 ||
              event.which == 8 ||
              (event.which >= 48 && event.which <= 57)
            ) {
              if (!$("#disval_" + pid).is("[readonly]"))
                $("#dis_" + pid).val("0");
            }
            //for invoice total
            invoice_total();
            //invoice total end
          }
        }
        function invoice_total() {
          var totalPrice = 0.0;
          var totalDis = 0.0;
          var net_amount = 0.0;
          var pre_bal = 0.0;
          $("#total_amount").html(totalPrice);
          if (!$("#total_discount").val()) $("#total_discount").val(totalDis);
          $("#net_amount").html(net_amount);

          var first_rowid = $("#myTable >tbody")
            .children("tr:first")
            .attr("id");
          if (first_rowid != "") {
            $("#myTable >tbody > tr").each(function (index) {
              var rowid = $(this).attr("id");
              if (rowid != "" && rowid) {
                if ($("#ftotal_" + rowid).val() != "")
                  totalPrice =
                    parseFloat(totalPrice) +
                    parseFloat($("#ftotal_" + rowid).val());
                if ($("#disval_" + rowid).val() != "")
                  totalDis =
                    parseFloat(totalDis) +
                    parseFloat($("#disval_" + rowid).val());
              }
            });

            $("#total_amount").html(fixdecimal(totalPrice));
            $("#total_discount").val(fixdecimal(totalDis));
            net_amount = fixdecimal(totalPrice - totalDis);
            $("#net_amount").html(net_amount);
          }
          extra_dis();
        }

        function discount() {
          var totalDis;
          if ($("#total_discount").val())
            totalDis = parseFloat($("#total_discount").val());
          else totalDis = 0;
          var totalPrice = parseFloat($("#total_amount").html());
          var net_amount;
          var pre_bal;
          var subtotal;
          if (totalPrice > 0) {
            net_amount = fixdecimal(totalPrice - totalDis);
            $("#net_amount").html(net_amount);
            extra_dis();
            /*subtotal  = parseFloat($("#sub_total").html());
  pre_bal = parseFloat($("#balance").val());
  $("#previous_bal").html(pre_bal);
	
  $("#payable_balance").html(subtotal+pre_bal);
var paid = $("#paid").val();
  $("#total_bal").html(fixdecimal(parseFloat(pre_bal)+parseFloat(subtotal)-parseFloat(paid)));*/
          }
        }
        function extra_dis() {
          var extraDis = 0;
          if (parseFloat($("#extra_discount").val())) {
            var dis_per = parseFloat($("#extra_discount").val());
            var extraDis = fixdecimal(
              (parseFloat($("#net_amount").html()) * dis_per) / 100
            );
          }

          $("#sub_total").html(
            parseFloat(parseFloat($("#net_amount").html()) - extraDis)
          );

          var paid = 0.0;
          if (parseFloat($("#paid").val()))
            paid = parseFloat($("#paid").val());

          var sub_total = parseFloat($("#sub_total").html());
          pre_bal = parseFloat($("#balance").val());
          $("#payable_balance").html(
            fixdecimal(parseFloat(pre_bal) + parseFloat(sub_total))
          );
          $("#previous_bal").html(pre_bal);

          $("#total_bal").html(
            fixdecimal(
              parseFloat(pre_bal) + parseFloat(sub_total) - parseFloat(paid)
            )
          );
        }
        function reset_value() {
          if ($("#total_discount").val() == "")
            $("#total_discount").val("0.00");

          if ($("#extra_discount").val() == "")
            $("#extra_discount").val("0.00");

          if ($("#paid").val() == "") $("#paid").val("0.00");
        }

        function ctn_to_unit(pkg_id) {
          var ctn_packing = parseInt($("#ctn_packing_" + pkg_id).html());
          var quantity = parseInt($("#qty_" + pkg_id).val());
          $("#qty_" + pkg_id).val(ctn_packing * quantity);
          editTotal(pkg_id);
        }

        function add() {
          var select_data = "";
          var table_row =
            '<tr id=""><td style="text-align:center;" id="count"></td><td>';
          select_data =
            '<select class="warehouse vertical-select" id="warehouse" data-rel="chosen" name="shop_warehouse[]"><option value="" style="min-width:100%;">Select Warehouse</option><option value="2">shop</option><option value="1">Main Gudam</option></select>';
          table_row = table_row + select_data;
          table_row =
            table_row +
            '</td><td><input style="width:100%;text-align:left;padding-left:5px;" type="text" class="alphanum_product vertical product_name" onFocus="pn_focus(this,this.id)" placeholder="Product Name" name="product_name[]"><input type="hidden" name="dname[]" value="" /><input type="hidden" name="dpprice[]" value="" /><input type="hidden" name="pid[]" value="" /><input type="hidden" name="total[]" value="" /><input type="hidden" name="net[]" value="" /></td>';
          table_row = table_row + '<td class="packing"></td>';
          table_row = table_row + '<td class="stock"></td>';

          table_row =
            table_row +
            '<td style="padding-right:3px;"><input class="num_only_decimal vertical" style="width:76%;" autocomplete="off" type="text" name="pprice[]" onFocus="price_focus(this,this.id)" value=""/><i class="glyphicon glyphicon-info-sign customtooltip" style="margin-left:3px;"></i></td><td><input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)" autocomplete="off" type="text" name="quantity[]" value="" /></td>';

          table_row = table_row + '<td class="total"></td>';

          table_row =
            table_row +
            '<td><input autocomplete="off" type="text" name="discount[]" onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" /></td>';
          table_row =
            table_row +
            '<td><input onFocus="disval_focus(this,this.id)"  class="num_only_decimal vertical" autocomplete="off" type="text" name="disval[]" value="" /></td><td class="net"></td>';
          table_row =
            table_row +
            '<td><a name="delete_link[]" onClick="delete_row(this)" class="delete" href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg" style="font-size: 20px;"></i></a></td></tr>';
          $("#myTable > tbody")
            .append(table_row)
            .ready(function () {
              $("select").chosen();
              invoice_total();
            });

          if (!$("#purchase_form").find("#submit_button").html())
            $("#purchase_form").append(
              '<button type="submit" id="submit_button" class="btn btn-success btn-sm verticalbtn" onClick="submitform(event)">Save Invoice</button>'
            );

          //for binding jquery
          $(".num_only_integer").numeric({
            allowMinus: false,
            allowDecSep: false,
          });
          $(".num_only_integer_quantity").numeric({
            allowMinus: false,
            allowDecSep: false,
            min: 1,
          });
          $(".num_only_decimal").numeric({ allowMinus: false });
          autocompletetext();
          enterbtn();
        }
        function clear_all() {
          var rows = 0;
          $("#myTable >tbody > tr").each(function () {
            if ($(this).attr("id") == "") return false;
            rows++;
            $(this).remove();
            if ($("#tbody tr").length < 9) add();
          });
          invoice_total();
          invoiceItems = {};
          $.ajax({
            method: "POST",
            async: false,
            url: "http://mcas.com.pk/system/admin/ajax/clear_autosave",
            data: { invoice_type: 1 },
          }).done(function (msg) { });
        }
        function delete_row(row_id) {
          if (row_id != "javascript:void(0)") {
            var rowno = $("#" + row_id).closest("tr")[0].rowIndex;
            $("#" + row_id).remove();
            autosave(rowno, "1");
            add();
          } else $(row_id).closest("tr").remove();

          var c = 1;
          invoice_total();
          count = $("#myTable >tbody >tr").length + 1;
          $("#myTable >tbody > tr").each(function () {
            if ($(this).attr("id") != "" && $(this).attr("id")) {
              $(this).find("td:eq(0)").text(c++);
            } else {
              $(this)
                .find("input[name^='product_name']")
                .focus(function (event) {
                  event.stopImmediatePropagation();
                });
              return false;
            }
          });
          invoice_total();
          if ($("#myTable >tbody >tr").length < 1)
            $("#submit_button").remove();
        }

        function get_company_bal(company_id) {
          if (company_id == "") {
            $("#balance").val("0");
            invoice_total();
          } else
            $.ajax({
              method: "POST",
              async: false,
              url: "http://mcas.com.pk/system/admin/ajax/c_bal",
              data: { c_id: company_id },
            }).done(function (msg) {
              $("#balance").val(msg);
              invoice_total();
            });
        }

        function autocompletetext() {
          $("input[name^='product_name']").each(function (i, el) {
            $(el)
              .autocomplete({
                source: function (request, response) {
                  $.post(
                    "http://mcas.com.pk/system/admin/ajax/product_list",
                    {
                      name: request.term,
                      sw: $(el).closest("td").prev("td").find("select").val(),
                      type: 3,
                    }
                  ).done(function (data, status) {
                    if (data) response(JSON.parse(data));
                  });
                },
                autoFocus: true,
                select: function (event, ui) {
                  var pid = ui.item.id + "_" + ui.item.sw,
                    ui;
                  item_select(
                    pid,
                    this,
                    ui.item.value,
                    ui.item.tp,
                    ui.item.stock,
                    ui.item.sw,
                    ui.item.id,
                    ui.item.pkg
                  );
                  if (!$(this).closest("tr").attr("id")) $(this).select();
                },
              })
              .blur(function () {
                var id = $(this).closest("tr").attr("id");
                if (id == "" && $(this).val() != "")
                  $(this).focus(function (event) {
                    event.stopImmediatePropagation();
                  });
              });
          });
        }

        function item_select(pid, thisobj, value, pprice, stock, sw, p, pkg) {
          if (pid) {
            if ($(thisobj).attr("id") == "name_" + pid) {
              $("#name_" + pid).val($("#dname_" + pid).val());
              return false;
            } else if (
              $("#myTable")
                .find("#" + pid)
                .html()
            ) {
              if ($(this).attr("id") == "name_" + pid) {
                $("#name_" + pid).val($("#dname_" + pid).val());
                return false;
              }
              $(this).val("");
              $("html, body").animate(
                { scrollTop: $("#" + pid).offset().top },
                1000
              );
              $("#" + pid + " td").addClass("light");
              setTimeout(function () {
                $("#" + pid + " td").addClass("dim");
                $("#" + pid + " td").removeClass("light");
              }, 3000);
              return false;
            }
          }
          $(thisobj).closest("tr").attr("id", pid);
          $("#" + pid + ' input[name^="pid"]').attr("id", "pid_" + pid);
          $("#pid_" + pid).val(p);

          $("#" + pid + " select")
            .attr("id", "sw_" + pid)
            .trigger("chosen:updated");

          $("#" + pid + ' input[name^="product_name"]').attr(
            "id",
            "name_" + pid
          );
          $("#name_" + pid).val(value);

          $("#" + pid + ' input[name^="dname"]').attr("id", "dname_" + pid);
          $("#dname_" + pid).val(value);

          $("#" + pid + " .packing").attr("id", "ctn_packing_" + pid);
          $("#ctn_packing_" + pid).html(pkg);
          $("#ctn_packing_" + pid).attr(
            "onclick",
            "ctn_to_unit('" + pid + "')"
          );

          $("#" + pid + " .stock").attr("id", "stock_" + pid);
          $("#stock_" + pid).html(stock);
          $("#" + pid + ' input[name^="pprice"]').attr("id", "pprice_" + pid);
          $("#pprice_" + pid).attr("onkeyup", "editTotal('" + pid + "')");
          $("#" + pid + ' input[name^="dpprice"]').attr(
            "id",
            "dpprice_" + pid
          );

          $("#" + pid + " .customtooltip").attr("id", "pp_" + pid);

          $("#" + pid + ' input[name^="quantity"]').attr("id", "qty_" + pid);
          $("#qty_" + pid).attr("onkeyup", "editTotal('" + pid + "')");
          $("#qty_" + pid).attr("onblur", "quantity('" + pid + "')");

          $("#" + pid + ' input[name^="discount"]').attr("id", "dis_" + pid);
          $("#dis_" + pid).attr("onkeyup", "editNet('" + pid + "',event)");

          $("#" + pid + ' input[name^="disval"]').attr("id", "disval_" + pid);
          $("#disval_" + pid).attr(
            "onkeyup",
            "editNet_disval('" + pid + "',event)"
          );

          $("#" + pid + " .net").attr("id", "net_" + pid);
          $("#" + pid + ' input[name^="net"]').attr("id", "fnet_" + pid);

          $("#" + pid + " .total").attr("id", "total_" + pid);
          $("#" + pid + ' input[name^="total"]').attr("id", "ftotal_" + pid);

          $("#" + pid + " .delete").attr(
            "onClick",
            "delete_row('" + pid + "')"
          );

          var c = 1;
          $("#myTable >tbody > tr").each(function () {
            if ($(this).attr("id") != "" && $(this).attr("id")) {
              $(this).find("td:eq(0)").text(c++);
            } else if ($(this).attr("id") == "") return false;
          });
          var rowno = $(thisobj).closest("tr")[0].rowIndex;

          $("#pprice_" + pid).val(pprice);
          $("#dpprice_" + pid).val(pprice);
          $("#qty_" + pid).val("1");
          if ($("#dis_" + pid).val() == "") $("#dis_" + pid).val("0");
          if ($("#disval_" + pid).val() == "") $("#disval_" + pid).val("0");

          if ($("#qty_" + pid).val() >= 0) editTotal(pid);
          //alert(rno);
          if (rowno) {
            //for auto save
            //invoiceItems["item_"+rno] !== 'undefined' && image_array.length > 0
            if (!invoiceItems["item_" + rowno])
              invoiceItems["item_" + rowno] = [];
            invoiceItems["item_" + rowno][0] = p;
            invoiceItems["item_" + rowno][1] = value;
            invoiceItems["item_" + rowno][2] = $("#pprice_" + pid).val();
            invoiceItems["item_" + rowno][3] = 1;
            invoiceItems["item_" + rowno][4] = $("#ftotal_" + pid).val();
            invoiceItems["item_" + rowno][5] = $("#dis_" + pid).val();
            invoiceItems["item_" + rowno][6] = $("#disval_" + pid).val();
            invoiceItems["item_" + rowno][7] = $("#fnet_" + pid).val();
            invoiceItems["item_" + rowno][8] = $("#sw_" + pid).val();
            if (
              invoiceItems["item_" + rowno][0] &&
              invoiceItems["item_" + rowno][3]
            )
              autosave(rowno);
          }
          if ($("#tbody tr").length - rowno <= 2) add();
        }

        function enterbtn() {
          $(".vertical-select").on(
            "chosen:showing_dropdown",
            function (evt, params) {
              select_check = 1;
            }
          );
          $(".vertical-select").on(
            "chosen:hiding_dropdown",
            function (evt, params) {
              select_check = 0;
            }
          );

          $("textarea,select,html").keydown(function (event) {
            event.stopImmediatePropagation();
            if (
              (event.metaKey || event.ctrlKey) &&
              String.fromCharCode(event.which).toLowerCase() === "s"
            ) {
              if (!$("#total_discount").prop("readonly"))
                $("#total_discount").focus();
              else if ($("#paid").length) $("#paid").focus();
              else $(".verticalbtn").focus();
              return false;
              event.preventDefault();
              return false;
            }
          });

          $(".verticalbtn").keydown(function (event) {
            event.stopImmediatePropagation();
            if (event.keyCode == 37) {
              $("#paid").focus();
              event.preventDefault();
              return false;
            }
          });
          $(".vertical").keydown(function (event) {
            event.stopImmediatePropagation();
            if (
              (event.metaKey || event.ctrlKey) &&
              String.fromCharCode(event.which).toLowerCase() === "s"
            ) {
              if (!$("#total_discount").prop("readonly"))
                $("#total_discount").focus();
              else if ($("#paid").length) $("#paid").focus();
              else $(".verticalbtn").focus();
              return false;
              event.preventDefault();
              return false;
            } else if (event.keyCode == 38) {
              var name = $(this).attr("name");
              name = name.replace("[]", "");

              if (
                name.indexOf("product_name") >= 0 &&
                $($(this).autocomplete("widget")).is(":visible")
              )
                return false;

              var curr_index = $("input[name^='" + name + "']").index(this);
              if (curr_index >= 1) {
                var previousfield = $("input[name^='" + name + "']").eq(
                  curr_index - 1
                );
                previousfield.focus(function (event) {
                  event.stopImmediatePropagation();
                });
                previousfield.select();
                event.preventDefault();
                return false;
              }
            } else if (event.keyCode == 40) {
              var name = $(this).attr("name");
              name = name.replace("[]", "");

              if (
                name.indexOf("product_name") >= 0 &&
                $($(this).autocomplete("widget")).is(":visible")
              )
                return false;

              var curr_index = $("input[name^='" + name + "']").index(this);
              if ($("input[name^='" + name + "']")[curr_index + 1] != null) {
                var nextfield = $("input[name^='" + name + "']").eq(
                  curr_index + 1
                );

                if (
                  !nextfield.attr("id") &&
                  !$("input[name^='" + name + "']")
                    .eq(curr_index)
                    .attr("id")
                )
                  nextfield = $("input[name^='" + name + "']").eq(curr_index);

                nextfield.focus(function (event) {
                  event.stopImmediatePropagation();
                });
                nextfield.select();
                event.preventDefault();
                return false;
                //alert(nextfield.val());
              }
            } else if (event.keyCode == 13 || event.keyCode == 39) {
              textboxes = $("input.vertical");
              currentBoxNumber = textboxes.index(this);
              if ($("#paid").is(":focus")) {
                $(".verticalbtn").focus();
                event.preventDefault();
                return false;
              } else if (textboxes[currentBoxNumber + 1] != null) {
                nextBox = textboxes[currentBoxNumber + 1];
                var nxt = currentBoxNumber + 1;
                var next_index = nxt;
                if ($(":input.vertical:eq(" + nxt + ")").prop("readonly")) {
                  nextBox = textboxes[currentBoxNumber + 2];
                  next_index = nxt + 1;
                  if (
                    $(":input.vertical:eq(" + (nxt + 1) + ")").prop(
                      "readonly"
                    )
                  ) {
                    nextBox = textboxes[currentBoxNumber + 3];
                    next_index = nxt + 2;
                  }
                }

                var tr1 = $(this).closest("tr").index();
                var tr2 = $(":input.vertical:eq(" + next_index + ")")
                  .closest("tr")
                  .index();
                if (
                  tr1 != tr2 &&
                  !$(":input.vertical:eq(" + next_index + ")")
                    .closest("tr")
                    .attr("id")
                )
                  nextBox = $('input[name^="product_name"]:not([id]):first');
                //nextBox = textboxes[currentBoxNumber];

                nextBox.focus(function (event) {
                  event.stopImmediatePropagation();
                });
                nextBox.select();
                event.preventDefault();
                return false;
              }
            } else if (event.keyCode == 37) {
              textboxes = $("input.vertical");
              currentBoxNumber = textboxes.index(this);
              if (currentBoxNumber == 1) {
                $("#comp_id").focus(function (event) {
                  event.stopImmediatePropagation();
                });
                //$(".company").chosen({});
                $("#comp_id").trigger("chosen:activate");
              } else if (
                ($("#paid").is(":focus") &&
                  $("#total_discount").prop("readonly")) ||
                $("#total_discount").is(":focus")
              ) {
                $('input[name^="product_name"]:not([id]):first').focus();
              } else if (textboxes[currentBoxNumber - 1] != null) {
                nextBox = textboxes[currentBoxNumber - 1];
                var nxt = currentBoxNumber - 1;
                if ($(":input.vertical:eq(" + nxt + ")").prop("readonly")) {
                  nextBox = textboxes[currentBoxNumber - 2];
                  if (
                    $(":input.vertical:eq(" + (nxt - 1) + ")").prop(
                      "readonly"
                    )
                  )
                    nextBox = textboxes[currentBoxNumber - 3];
                }
                nextBox.focus(function (event) {
                  event.stopImmediatePropagation();
                });
                nextBox.select();
                event.preventDefault();
                return false;
              }
            }
          });

          $('input[name^="product_name"]').blur(function (event) {
            //complete the name of product if half removed
            event.stopImmediatePropagation();
            var thisobj = this;
            var id = $(this).closest("tr").attr("id");
            if (id != "") $("#name_" + id).val($("#dname_" + id).val());

            if (!id && $(this).val() != "") {
              var code = $(this).val();
              $.ajax({
                method: "POST",
                async: false,
                url: "",
                data: {
                  p_code: code,
                  sw: $(this).closest("td").prev("td").find("select").val(),
                },
              }).done(function (msg) {
                if (msg) {
                  var arr = msg.split("/");
                  item_select(
                    arr[0] + "_" + arr[5],
                    thisobj,
                    arr[1],
                    arr[2],
                    arr[5],
                    arr[0]
                  );
                }
              });
            }
          });

          /*Auto Save Start*/
          $('input[name^="pprice"]').blur(function (event) {
            event.stopImmediatePropagation();
            var id = $(this).closest("tr").attr("id");
            //reappear the price if leave empty
            if (
              $("#pprice_" + id).val() == "" ||
              $("#pprice_" + id).val() == 0
            ) {
              $("#pprice_" + id).val($("#dpprice_" + id).val());
              editTotal(id);
            }

            var rowno = $(this).closest("tr")[0].rowIndex;
            if (
              id &&
              invoiceItems["item_" + rowno][2] != $("#pprice_" + id).val()
            ) {
              invoiceItems["item_" + rowno][2] = $("#pprice_" + id).val();
              if (
                invoiceItems["item_" + rowno][0] &&
                invoiceItems["item_" + rowno][3]
              )
                autosave(rowno);
            }
          });
          $('input[name^="quantity"]').blur(function (event) {
            event.stopImmediatePropagation();
            var id = $(this).closest("tr").attr("id");
            var rowno = $(this).closest("tr")[0].rowIndex;
            if (
              id &&
              invoiceItems["item_" + rowno][3] != $("#qty_" + id).val()
            ) {
              invoiceItems["item_" + rowno][3] = $("#qty_" + id).val();
              invoiceItems["item_" + rowno][4] = $("#ftotal_" + id).val();
              invoiceItems["item_" + rowno][5] = 0;
              invoiceItems["item_" + rowno][6] = 0;
              invoiceItems["item_" + rowno][7] = $("#fnet_" + id).val();
              if (
                invoiceItems["item_" + rowno][0] &&
                invoiceItems["item_" + rowno][2]
              )
                autosave(rowno);
            }
          });
          $('input[name^="discount"]').blur(function (event) {
            event.stopImmediatePropagation();
            var id = $(this).closest("tr").attr("id");
            if (id && $(this).val() == "") $(this).val("0");
            var rowno = $(this).closest("tr")[0].rowIndex;
            if (
              id &&
              invoiceItems["item_" + rowno][5] != $("#dis_" + id).val()
            ) {
              invoiceItems["item_" + rowno][5] = $("#dis_" + id).val();
              invoiceItems["item_" + rowno][6] = $("#disval_" + id).val();
              invoiceItems["item_" + rowno][7] = $("#fnet_" + id).val();
              if (
                invoiceItems["item_" + rowno][0] &&
                invoiceItems["item_" + rowno][2] &&
                invoiceItems["item_" + rowno][3]
              )
                autosave(rowno);
            }
          });
          $('input[name^="disval"]').blur(function (event) {
            event.stopImmediatePropagation();
            var id = $(this).closest("tr").attr("id");
            if (id && $(this).val() == "") $(this).val("0");
            var rowno = $(this).closest("tr")[0].rowIndex;
            if (
              id &&
              invoiceItems["item_" + rowno][6] != $("#disval_" + id).val()
            ) {
              invoiceItems["item_" + rowno][6] = $("#disval_" + id).val();
              invoiceItems["item_" + rowno][5] = $("#dis_" + id).val();
              invoiceItems["item_" + rowno][7] = $("#fnet_" + id).val();
              if (
                invoiceItems["item_" + rowno][0] &&
                invoiceItems["item_" + rowno][2] &&
                invoiceItems["item_" + rowno][3]
              )
                autosave(rowno);
            }
          });
          /*Auto Save End*/
        }
        function autosave(row_no, del) {
          if (!del) del = 0;
          $.ajax({
            method: "POST",
            url: "http://mcas.com.pk/system/admin/ajax/invoice_autosave",
            data: {
              itemarr: invoiceItems["item_" + row_no],
              rowno: row_no,
              invoice_type: 1,
              action: del,
            },
          }).done(function (msg) { });
        }

        //force focusing on first empty/avaliable row and select the text/number in textbox
        function pn_focus(thisobj, id) {
          //pn = product name
          if ($(thisobj).closest("tr")[0].rowIndex != 1) {
            var row_index = $(thisobj).closest("tr")[0].rowIndex;
            var pre_row_id = $("tr")
              .eq(row_index - 1)
              .attr("id");
            if (
              $("tr:eq(" + row_index + ")" + " select").val() == "" &&
              pre_row_id != ""
            ) {
              var sw = $("#" + pre_row_id + " select").val();
              $("tr:eq(" + row_index + ")" + " select")
                .val(sw)
                .trigger("chosen:updated");
            }
          }
          if (
            $('input[name^="product_name"]:not([id]):first').is(":focus") ||
            ($(thisobj).val() != "" && $(thisobj).attr("id") != "")
          ) {
            return false;
            $(thisobj).select();
          } else $('input[name^="product_name"]:not([id]):first').focus();
        }
        function quantity_focus(thisobj, id) {
          if (
            $('input[name^="quantity"]:not([id]):first').is(":focus") ||
            ($(thisobj).val() != "" && $(thisobj).attr("id") != "")
          ) {
            return false;
            $(thisobj).select();
          } else $('input[name^="quantity"]:not([id]):first').focus();
        }
        function price_focus(thisobj, id) {
          if (
            $('input[name^="pprice"]:not([id]):first').is(":focus") ||
            ($(thisobj).val() != "" && $(thisobj).attr("id") != "")
          ) {
            return false;
            $(thisobj).select();
          } else $('input[name^="pprice"]:not([id]):first').first().focus();
        }
        function discount_focus(thisobj, id) {
          if (
            $('input[name^="discount"]:not([id]):first').is(":focus") ||
            ($(thisobj).val() != "" && $(thisobj).attr("id") != "")
          ) {
            return false;
            $(thisobj).select();
          } else $('input[name^="discount"]:not([id])').first().focus();
        }
        function disval_focus(thisobj, id) {
          if (
            $('input[name^="disval"]:not([id]):first').is(":focus") ||
            ($(thisobj).val() != "" && $(thisobj).attr("id") != "")
          ) {
            return false;
            $(thisobj).select();
          } else $('input[name^="disval"]:not([id])').first().focus();
        }
        //force focusing end

        // $(document).ready(function () {
        //   autocompletetext();
        //   enterbtn();
        //   $("#comp_id").chosen({});
        //   $(".chosen-container").bind("keydown", function (e) {
        //     e.stopImmediatePropagation();
        //     if ((e.which === 13 || e.which === 39) && select_check == 0) {
        //       $("input.vertical")[1].focus(function (event) {
        //         event.stopImmediatePropagation();
        //       });
        //     }
        //   });
        //   $("#comp_id").trigger("chosen:activate");
        //   tooltipfunction();

        //   $("#comp_id").click(function (event) {
        //     event.stopImmediatePropagation();
        //     var formcheck = 1;
        //     if ($('input[name^="pid"]').eq(0).val() == "") {
        //       e.preventDefault();
        //       return false;
        //     }
        //     $('input[name^="pid"]').each(function (e) {
        //       var indexofelement = $('input[name^="pid"]').index(this);
        //       if (
        //         $('input[name^="pid"]').eq(indexofelement).val() != "" &&
        //         ($('input[name^="price"]').eq(indexofelement).val() == "" ||
        //           $('input[name^="quantity"]').eq(indexofelement).val() == "")
        //       ) {
        //         var rowid = $(this).closest("tr").attr("id");
        //         $("#" + rowid + " td").addClass("light");
        //         setTimeout(function () {
        //           $("#" + rowid + " td").addClass("dim");
        //           $("#" + rowid + " td").removeClass("light");
        //         }, 3000);
        //         e.preventDefault();
        //         formcheck = 2;
        //       }
        //       if ($('input[name^="pid"]').eq(indexofelement).val() == "")
        //         return false;
        //     });
        //     if (formcheck == 1) {
        //       element.setCustomValidity("");
        //       $("#purchase_form").submit();
        //     }
        //   });
        // });

        function tooltipfunction() {
          // Add tooltip
          $(".customtooltip").tooltip({
            trigger: "click",
            title: fetchData,
            html: true,
            placement: "top",
          });

          $(".customtooltip").on("mouseleave", function () {
            $(this).tooltip("hide");
          });

          function fetchData() {
            $(".customtooltip").tooltip({ title: "" });
            var fetch_data = "";
            var element = $(this);
            var elementid = element.closest("tr").attr("id");
            var company_id = $("#comp_id").val();
            if (elementid != "" && company_id != "")
              $.ajax({
                url: "http://mcas.com.pk/system/admin/ajax/pre_purchase",
                method: "POST",
                async: false,
                data: { id: elementid, comp_id: company_id },
                success: function (data) {
                  fetch_data = data;
                },
              });
            return fetch_data;
          }
        }
        function submitform(e) {
          var formcheck = 1;
          if ($('input[name^="pid"]').eq(0).val() == "") {
            e.preventDefault();
            return false;
          }
          $('input[name^="pid"]').each(function () {
            var indexofelement = $('input[name^="pid"]').index(this);
            if (
              $('input[name^="pid"]').eq(indexofelement).val() != "" &&
              ($('input[name^="price"]').eq(indexofelement).val() == "" ||
                $('input[name^="quantity"]').eq(indexofelement).val() == "")
            ) {
              var rowid = $(this).closest("tr").attr("id");
              $("#" + rowid + " td").addClass("light");
              setTimeout(function () {
                $("#" + rowid + " td").addClass("dim");
                $("#" + rowid + " td").removeClass("light");
              }, 3000);
              e.preventDefault();
              formcheck = 2;
            }
            if ($('input[name^="pid"]').eq(indexofelement).val() == "")
              return false;
          });
          if (formcheck == 1) {
            element.setCustomValidity("");
            $("#purchase_form").submit();
          }
        }
      </script>
      <style>
        #tbody input[type="text"] {
          width: 100%;
        }

        #myTable .chosen-container a {
          height: 25px;
        }

        #myTable .chosen-container a span {
          line-height: 18px;
        }

        #myTable .chosen-container a div {
          padding-top: 2px;
        }
      </style>
      <div id="content" class="col-lg-10 col-sm-10">
        <!-- content starts -->
        <div>
          <ul class="breadcrumb">
            <li>
              <a href="http://mcas.com.pk/system/admin/dashboard">Dashboard</a>
            </li>
            <li>
              <a href="http://mcas.com.pk/system/admin/purchase_invoice">Purchase Invoice</a>
            </li>
          </ul>
        </div>
        <form class="addform" role="form" method="post" enctype="multipart/form-data" action="" >
          <div class="row">
            <div class="box col-md-12">
              <div class="box-inner">
                <div class="box-header well" data-original-title="">
                  <h2><i class="glyphicon glyphicon-plus"></i>Add Purchase Invoice</h2>
                </div>
                <div class="box-content" id="add_form">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label class="control-label" for="Compnay Name">Company</label>
                      <div class="controls">
                      <select id="company_id"  data-rel="chosen"
                          name="company_name" required>
                          <option value="" style="min-width:100%;">Select Company</option>
                          @foreach($company as $company)
                          <option value="{{$company->name}}">{{$company->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="Date of Purchase">Date</label>
                      <input title="Please Select Date of Purchase" data-toggle="tooltip" type="text"
                        style="background-color:#FFF;" class="form-control datetime-purchase vertical" id="date"
                        value="11-01-2023" name="date" placeholder="Enter Date">
                    </div>

                    <div class="form-group col-md-3">
                      <label for="Purchase Invoice Number">Invoice No.</label>
                      <input type="text" autocomplete="off" title="Purchase Invoice No." data-toggle="tooltip"
                        class="form-control vertical" id="invoice" name="invoice" placeholder="Invoice Number">
                    </div>

                    <div class="form-group col-md-2">
                      <label for="Company Previous Balance">Balance</label>
                      <input type="text" title="Previous Balance of Company" data-toggle="tooltip" class="form-control"
                        id="old_balance" readonly value="0" name="old_balance" placeholder="Balance">
                    </div>
                  </div>

                </div>
                <!--/span-->
              </div>

              <div class="row" >
                <div class="box col-md-10">
                  <div class="box-inner">
                    <div class="box-header well" data-original-title="">
                      <h2>
                        <i class="glyphicon glyphicon-user"></i>Purchase Invoice
                      </h2>
                    </div>
                    <div class="box-content">
                      <table class="table table-striped table-bordered bootstrap-datatable responsive" id="myTable">
                        <thead>
                          <tr>
                            <th width="50">S.No</th>
                            <th width="90">Shop/Warehouse</th>
                            <th width="215">Product Name</th>
                            <th width="50">Pkg</th>
                            <th width="90">Stock</th>
                            <th width="100" style="min-width: 85px">Price</th>
                            <th width="90">Quantity</th>
                            <th width="110">Total</th>
                            <th width="80">Dis (%)</th>
                            <th width="80">Dis (Rs)</th>
                            <th width="110">Net</th>
                            <th width="30"></th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                            <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                @foreach($warehouses as $warehous)
                                <option value="{{$warehous->name}}">{{$warehous->name}}</option>
                                @endforeach
                              </select>
                            </td>
                            <td>
                              <input style="
                                  width: 100%;
                                  text-align: left;
                                  padding-left: 5px;
                                " onFocus="pn_focus(this,this.id)" type="text" 
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="color_focus(this,this.id)"
                                autocomplete="off" type="text" class="color" id="color" name="color[]" value="" />
                            </td>

                            <td>
                             <select class="num_only_integer_quantity vertical" onFocus="size_no_focus(this,this.id)" autocomplete="off" name="size[]" id="size_no" class="size_no">
                              <!-- <option value="">Select size </option> -->
                             </select> 
                            </td>
                            

                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" id="price" name="price[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                 type="text" class="quantity" name="quantity[]" value="" />
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="total_focus(this,this.id)"
                                autocomplete="off" type="text" id="total" name="total[]" value="" />
                            </td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" id="discount" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="less_focus(this,this.id)"
                                autocomplete="off" type="text" id="less" name="less[]" value="" />
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="net_focus(this,this.id)"
                                autocomplete="off" type="text" id="net" name="net[]" value="" />
                            </td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>

                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                  width: 100%;
                                  text-align: left;
                                  padding-left: 5px;
                                " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>

                          <!-- <script>
                            $(window).on("load", function () {
                              invoice_total();
                            });
                          </script> -->
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                width: 100%;
                                text-align: left;
                                padding-left: 5px;
                              " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                width: 100%;
                                text-align: left;
                                padding-left: 5px;
                              " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                width: 100%;
                                text-align: left;
                                padding-left: 5px;
                              " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                width: 100%;
                                text-align: left;
                                padding-left: 5px;
                              " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                width: 100%;
                                text-align: left;
                                padding-left: 5px;
                              " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                width: 100%;
                                text-align: left;
                                padding-left: 5px;
                              " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                          <tr id="">
                            <td style="text-align: center" id="count">&nbsp;</td>
                            <td>
                              <select class="warehouse vertical-select" id="warehouse" data-rel="chosen"
                                name="shop_warehouse[]">
                                <option value="" style="min-width: 100%">
                                  Select Warehouse
                                </option>
                                <option value="2">shop</option>
                                <option value="1">Main Gudam</option>
                              </select>
                            </td>
                            <td>
                              <input style="
                                width: 100%;
                                text-align: left;
                                padding-left: 5px;
                              " onFocus="pn_focus(this,this.id)" type="text"
                                class="alphanum_product vertical product_name" placeholder="Product Name"
                                name="product_name[]" />
                              <input id="" type="hidden" name="dname[]" value="" />
                              <input id="" type="hidden" name="dpprice[]" value="" />
                              <input id="" type="hidden" name="pid[]" value="" />
                              <input type="hidden" name="total[]" value="" />
                              <input type="hidden" name="net[]" value="" />
                            </td>

                            <td class="packing"></td>

                            <td class="stock"></td>
                            <td style="padding-right: 3px">
                              <input style="width: 76%" onFocus="price_focus(this,this.id)" autocomplete="off"
                                class="num_only_decimal vertical" type="text" name="pprice[]" value="" /><i
                                class="glyphicon glyphicon-info-sign customtooltip" style="margin-left: 3px"></i>
                            </td>
                            <td>
                              <input class="num_only_integer_quantity vertical" onFocus="quantity_focus(this,this.id)"
                                autocomplete="off" type="text" name="quantity[]" value="" />
                            </td>
                            <td class="total"></td>
                            <td>
                              <input type="text" name="discount[]" autocomplete="off"
                                onFocus="discount_focus(this,this.id)" class="num_only_decimal vertical" value="" />
                            </td>
                            <td>
                              <input class="num_only_decimal vertical" onFocus="disval_focus(this,this.id)"
                                autocomplete="off" type="text" name="disval[]" value="" />
                            </td>
                            <td class="net"></td>
                            <td>
                              <a name="delete_link[]" onClick="delete_row(this)" class="delete"
                                href="javascript:void(0)"><i class="glyphicon glyphicon-remove fa-lg"
                                  style="font-size: 20px"></i></a>
                            </td>
                          </tr>
                        </tbody>
                        <tfoot id="tfoot">
                          <tr>
                            <td colspan="6">
                              <button type="button" id="btn_add" class="btn btn-success btn-sm" onClick="add()">Add Line</button>&nbsp;<button type="button" id="clear" class="btn btn-success btn-sm" onClick="clear_all()">Clear</button> 
                            </td>
                            <td colspan="3" class="total">Current Invoice:</td>
                            <td colspan="2" class="total-val" id="total_amount">
                              0.00
                            </td>
                          </tr>

                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">Discount:</td>
                            <td colspan="2" class="discount-td">
                              <input readonly class="form-control discount-val num_only_decimal vertical"
                                autocomplete="off" style="
                                background-color: #fff;
                                padding-left: 2px;
                                font-size: 16px;
                              " onKeyUp="discount();" onBlur="reset_value();" value="0.00" id="total_discount"
                                type="text" name="total_discount" />
                            </td>
                          </tr>

                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Payable Invoice:</td>
                            <td colspan="2" class="total-val" id="net_amount">
                              0.00
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="discount">
                              Extra Discount(%):
                            </td>
                            <td colspan="2" class="discount-td">
                              <input class="form-control discount-val num_only_decimal vertical" autocomplete="off"
                                style="
                                background-color: #fff;
                                padding-left: 2px;
                                font-size: 16px;
                              " onKeyUp="extra_dis();" onBlur="reset_value();" value="0.00" id="extra_discount"
                                type="text" name="extra_discount" />
                            </td>
                          </tr>

                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Sub Total:</td>
                            <td colspan="2" class="total-val" id="sub_total">
                              0.00
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="prebal">Previous Balance:</td>
                            <td colspan="2" class="prebal-val" id="previous_bal">
                              0.00
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Total:</td>
                            <td colspan="2" class="total-val" id="payable_balance">
                              0.00
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="discount" style="padding-top: 8px">
                              Paid:
                            </td>
                            <td colspan="2" class="discount-td">
                              <input id="paid" class="form-control discount-val num_only_decimal vertical"
                                autocomplete="off" style="
                                background-color: #fff;
                                padding-left: 2px;
                                font-size: 16px;
                              " onKeyUp="invoice_total();" onBlur="reset_value();" value="0.00" type="text"
                                name="paid" />
                            </td>
                          </tr>
                          <tr>
                            <td colspan="6"></td>
                            <td colspan="3" class="total">Net Balance:</td>
                            <td colspan="2" class="total-val" id="total_bal">
                              0.00
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                      <div class="row">
                        <div class="col-sm-12">
                          <button type="submit" name="submit" value="s" id="submit_button"
                            class="btn btn-success btn-sm verticalbtn" onClick="submitform(event)">
                            Save Invoice</button>&nbsp;<button type="submit" id="submit_button1" name="submit"
                            value="snp" class="btn btn-success btn-sm verticalbtn1" onClick="submitform(event)">
                            Save & Print
                          </button>
                        </div>
                        <div class="col-sm-12"></div>
                        <div class="col-sm-12"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/span-->
                <div class="col-md-2" style="padding-left: 0px">
                  <div class="form-group">
                    <label style="font-size: 12px">Printable Invoice Notes</label>
                    <textarea class="form-control" name="printable" style="resize: none"></textarea>
                  </div>
                  <div class="form-group">
                    <label style="font-size: 12px">Non-Printable (Private) Invoice Notes</label>
                    <textarea class="form-control" name="non_printable" style="resize: none"></textarea>
                  </div>
                </div>
              </div>
        </form>

        <!--/row-->

        <!--/row-->
        <!-- content ends -->
      </div>
      <!--/#content.col-md-0-->
    </div>
    <!--/fluid-row-->
  </div>
  <!--/.fluid-container-->

  <!-- external javascript -->

  <!-- <script>
    $(document).ready(function () {
      $('#myTable').DataTable({
        responsive: true
      });
    });
  </script> -->
  <!-- <script type="application/javascript">
    // $.widget.bridge("uitooltip", $.ui.tooltip);
    // $.widget.bridge("uibutton", $.ui.button);

    $(document).ready(function () {
      // confirmation
      $(".confirm-dialog").on("click", function () {
        event.preventDefault();
        var lnk = $(this).attr("href");
        $.confirm({
          title: "Confirmation",
          content: "To confirm please click on proceed.",
          icon: "fa fa-question-circle",
          animation: "scale",
          closeAnimation: "scale",
          opacity: 0.5,
          buttons: {
            confirm: {
              text: "Proceed",
              btnClass: "btn-blue",
              action: function () {
                location.href = lnk;
              },
            },
            cancel: function () { },
          },
        });
      });
    });
  </script> -->


  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <!--  data table plugin -->
  <script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

  <!-- select or dropdown enhancer -->

  <!-- library for making tables responsive -->
  <!-- <script src="http://mcas.com.pk/system/assets/admin/bower_components/responsive-tables/responsive-tables.js"></script> -->


  <script>

$(document).ready(function(e){

  

$(document).on('change', '#company_id', function(){


var company_id = $('#company_id').val();

// alert(company_id);
 $.ajax({

     type: "GET",
     url:"fetch-company/"+company_id,
     datatype:"JSON",
     success: function(response)
     {
      // console.log(response.company);
        //  $('#booker').val(response.company.id);
         $('#company_ids').val(response.company.id);
         $('#old_balance').val(response.company.open_balance);
        //  $('#company_name').val(response.company.name);
        //  $('#address').val(response.company.address);
     }
 });

});



        $(document).on('change', '.product_name', function(){


        var product_name = $('.product_name').val();

        // alert(product_name);
        $.ajax({

            type: "GET",
            url:"fetch-product-detail/"+product_name,
            datatype:"JSON",
            success: function(response)
            {
              console.log(response.product);
              // $('#colors_ids').val(response.product.color_id);

              $('#size_no').html('');
                // console.log(color);
                $.each(response.product, function(key, item){
                $('#color').val(item.color_id);
                $('#price').val(item.purchase_price);
                //  $('#company_name').val(item.quantity);
                //  $('#address').val(response.product.address);


                var category_table = item.category_id;
                     
                     if(category_table == 1)
                        $('#size_no').append(
                                '<option value="'+item.size_38+'">'+item.size_38+'</option>',
                                '<option value="'+item.size_39+'">'+item.size_39+'</option>',
                                '<option value="'+item.size_40+'">'+item.size_40+'</option>',
                                '<option value="'+item.size_41+'">'+item.size_41+'</option>',
                                '<option value="'+item.size_42+'">'+item.size_42+'</option>',
                                '<option value="'+item.size_43+'">'+item.size_43+'</option>',
                                '<option value="'+item.size_44+'">'+item.size_44+'</option>',
                                '<option value="'+item.size_45+'">'+item.size_45+'</option>',
                                '<option value="'+item.size_46+'">'+item.size_46+'</option>',
                           
                            );

                           else if(category_table == 2)

                                $('#size_no').append(
                                '<option value="'+item.l_size_36+'">'+item.l_size_36+'</option>',
                                '<option value="'+item.l_size_37+'">'+item.l_size_37+'</option>',
                                '<option value="'+item.l_size_38+'">'+item.l_size_38+'</option>',
                                '<option value="'+item.l_size_39+'">'+item.l_size_39+'</option>',
                                '<option value="'+item.l_size_40+'">'+item.l_size_40+'</option>',
                                '<option value="'+item.l_size_41+'">'+item.l_size_41+'</option>',
                                '<option value="'+item.l_size_42+'">'+item.l_size_42+'</option>',
                           
                            );

                            else

                                // kids sizes portions

                                $('#size_no').append(

                                '<option value="'+item.k_size_1+'">'+item.k_size_1+'</option>',
                                '<option value="'+item.k_size_2+'">'+item.k_size_2+'</option>',
                                '<option value="'+item.k_size_3+'">'+item.k_size_3+'</option>',
                                '<option value="'+item.k_size_4+'">'+item.k_size_4+'</option>',
                                '<option value="'+item.k_size_5+'">'+item.k_size_5+'</option>',
                                '<option value="'+item.k_size_6+'">'+item.k_size_6+'</option>',
                                '<option value="'+item.k_size_7+'">'+item.k_size_7+'</option>',
                                '<option value="'+item.k_size_8+'">'+item.k_size_8+'</option>',
                                '<option value="'+item.k_size_9+'">'+item.k_size_9+'</option>',
                                '<option value="'+item.k_size_10+'">'+item.k_size_10+'</option>',
                                '<option value="'+item.k_size_11+'">'+item.k_size_11+'</option>',
                                '<option value="'+item.k_size_12+'">'+item.k_size_12+'</option>',
                                '<option value="'+item.k_size_13+'">'+item.k_size_13+'</option>',
                                '<option value="'+item.k_size_17+'">'+item.k_size_17+'</option>',
                                '<option value="'+item.k_size_18+'">'+item.k_size_18+'</option>',
                                '<option value="'+item.k_size_19+'">'+item.k_size_19+'</option>',
                                '<option value="'+item.k_size_20+'">'+item.k_size_20+'</option>',
                                '<option value="'+item.k_size_21+'">'+item.k_size_21+'</option>',
                                '<option value="'+item.k_size_22+'">'+item.k_size_22+'</option>',
                                '<option value="'+item.k_size_23+'">'+item.k_size_23+'</option>',
                                '<option value="'+item.k_size_24+'">'+item.k_size_24+'</option>',
                                '<option value="'+item.k_size_25+'">'+item.k_size_25+'</option>',
                                '<option value="'+item.k_size_26+'">'+item.k_size_26+'</option>',
                                '<option value="'+item.k_size_27+'">'+item.k_size_27+'</option>',
                                '<option value="'+item.k_size_28+'">'+item.k_size_28+'</option>',
                                '<option value="'+item.k_size_29+'">'+item.k_size_29+'</option>',
                                '<option value="'+item.k_size_30+'">'+item.k_size_30+'</option>',
                                '<option value="'+item.k_size_31+'">'+item.k_size_31+'</option>',
                                '<option value="'+item.k_size_32+'">'+item.k_size_32+'</option>',
                                '<option value="'+item.k_size_33+'">'+item.k_size_33+'</option>',
                                '<option value="'+item.k_size_34+'">'+item.k_size_34+'</option>',
                                '<option value="'+item.k_size_35+'">'+item.k_size_35+'</option>',



                                );
              });
            }
        });

        });


                $('.addform').change(function(){

                var price = $('#price').val();
                var quantity = $('#quantity').val();

                var total = price * quantity;

                if(total == 0)
                {
                    $('#total').val('');

                }
                else{
                    $('#total').val(total);
                    $('#less').val('');
                }

                    var total = $('#total').val();
                    var discount = $('#discount').val();

                    var percentage = (discount/100);
                    var totalDiscount = total - (total * percentage);
                    var less = total - totalDiscount;
                    var net = total - less;


                    if(percentage == 0){
                    $('#less').val('');
                    }
                    else{
                        $('#less').val(less);
                      

                      
                        $('#net').val(net);
                    }
                  
                    

                  
                  });

});
    </script>



</body>

</html>