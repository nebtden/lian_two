$(function(){
    // var tree = [
    //     {
    //         text: "Parent 1",
    //         nodes: [
    //             {
    //                 text: "Child 1",
    //                 nodes: [
    //                     {
    //                         text: "Grandchild 1"
    //                     },
    //                     {
    //                         text: "Grandchild 2"
    //                     }
    //                 ]
    //             },
    //             {
    //                 text: "Child 2"
    //             }
    //         ]
    //     },
    //     {
    //         text: "Parent 2"
    //     },
    //     {
    //         text: "Parent 3"
    //     },
    //     {
    //         text: "Parent 4"
    //     },
    //     {
    //         text: "Parent 5"
    //     }
    // ];



    $.get("/admin/api/tree",function(data){
        console.log('data');
        console.log(data);
        // tree = data;

        $('#tree').treeview({data: data});
        var initSelectableTree = function() {
            return $('#tree').treeview({
                data: data,
            });
        };
        var findSelectableNodes = function() {
            return $selectableTree.treeview('search', [ $('#input-select-node').val(), { ignoreCase: false, exactMatch: false } ]);
        };
        var $selectableTree = initSelectableTree();
        $('#input-select-node').on('keyup', function (e) {
            selectableNodes = findSelectableNodes();
            $('.select-node').prop('disabled', !(selectableNodes.length >= 1));
        });
        $('#btn-select-node.select-node').on('click', function (e) {
            $selectableTree.treeview('selectNode', [ selectableNodes, { silent:1 }]);
        });

    });




});
