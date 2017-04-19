<link rel="stylesheet" type="text/css" href="{{ asset('/common/ztree/css/zTreeStyle/zTreeStyle.css') }}" />
<script type="text/javascript" src="{{ asset('/common/ztree/js/jquery.ztree.all.js') }}"></script>
<script type="text/javascript">
    // 创建全局变量
    var zTreeObj;

    $().ready( function() {
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "pId",
                    rootPId: 0
                }
            },
            check: {
                enable: true
            }
        };

        var zNodes = [
            {
                id:1,
                pid:0,
                checked:true,
                name:'北京'
            },
            {
                id:2,
                pid:0,
                name:'湖北'
            }
        ];

        // 初始化
        zTreeObj = $.fn.zTree.init($("#areaTree"), setting, zNodes);
        zTreeObj.expandAll(true);

        var array = zTreeObj.getCheckedNodes(true);
        if(array != null && array.length > 0){
            for(var i = 0 ; i < array.length ; i++){
                var node = array[i];
                while(node != null){
                    node = node.getParentNode();
                    if(node == null){
                        break;
                    }
                    node.halfCheck = true;
                    node.checked = true;
                }
            }
        }

        zTreeObj.refresh();
    });

    // 获取地区查询条件
    function getCondition(){
        var jsonArray = [];
        var array = zTreeObj.getCheckedNodes(true);
        if(array != null && array.length > 0){
            for(var i = 0 ; i < array.length ; i++){
                console.log(array[i]);
                if(!array[i].isParent){
                    var json = {};
//                    var city = array[i];
//                    var region = city.getParentNode();
//                    var province = region.getParentNode();
//                    json.value = province.name + region.name + city.name;
                    jsonArray.push(json);
                }
            }
            var str = JSON.stringify(jsonArray);
            return str;
        }
        else{
            return "";
        }
    }

    // 获取地区查询条件(ID值)
    function getConditionForId(){
        var jsonArray = [];
        var array = zTreeObj.getCheckedNodes(true);
        if(array != null && array.length > 0){
            for(var i = 0 ; i < array.length ; i++){
                console.log(array[i]);
//                if(!array[i].isParent){
//                    var json = {};
//                    json.id = array[i].id;
//                    jsonArray.push(json);
//                }
            }
            var str = JSON.stringify(jsonArray);
            return str;
        }
        else{
            return "";
        }
    }

</script>
<div id="treeBox" style="width:165px;height:760px;overflow-y:auto;margin-left:15px;margin-right:15px;">
    <br/>
    <br/>
    &nbsp;&nbsp;【地区选择】：
    <br/>
    <br/>
    <div id="areaTree" class="ztree">
    </div>
</div>
