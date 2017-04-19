<script type="text/javascript">
    $().ready( function() {

        var $pager = $("#pager");

        $pager.pager({
            pagenumber: {{$page_number}},
            pagecount: {{$page_count}},
            buttonClickCallback: $.gotoPage
        });

        $(".pgNext").live("click",function() {
            $("#waitingBody").waiting({ fixed: true });
        })

        $(".page-number").live("click",function() {
            $("#waitingBody").waiting({ fixed: true });
        })
    })
</script>
<span id="pager"></span>
<input type="hidden" name="pageNumber" id="pageNumber" value="{{$page_number}}" />
<input type="hidden" name="pager.orderBy" id="orderBy" value="1" />
<input type="hidden" name="pager.order" id="order" value="1" />