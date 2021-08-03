(function ($) {
    $.fn.menuThree = function (options = {}) {

        var defaults = {
            domThreeItem : '.list-group-item',
            nestableList : '.nested_sortable',
            datakey : 'menu-three-key'
        }
        var o = [];
        let opts = {
            ...defaults,
            ...options
        }
        let self = $(this);
        let base_iteration = 0;
        let base_sublevels_iteration = 0;
        // let base_it_childs = 0;

        function WalkerTexasRanger($scope, $arrayScope, $isSubLevel = false) {
            let childrens = $scope ? $scope.children( opts.domThreeItem ) : self.children( opts.domThreeItem );

            $.each(childrens, function(i, child) {
                // console.log(child)
                let data_keys = $(child).find( '['+opts.datakey+']' ).not( $(child).find(opts.nestableList + ' ['+opts.datakey+']') );

                if(o[base_iteration] == null && !$scope) {
                    o[base_iteration] = {};
                }
                else {
                    $arrayScope[base_sublevels_iteration] = {}
                }

                $.each(data_keys, function(k, data_key) {
                    let el = $(data_key)
                    let val = el.val();
                    if(el.is(':radio') || el.is(':checkbox')) {
                        val = el.is(':checked') ? 1 : 0;
                    }
                    $arrayScope ?  $arrayScope[ base_sublevels_iteration ][ el.attr( opts.datakey ) ] = val : o[base_iteration][ el.attr( opts.datakey ) ] = val;
                })

                $arrayScope ? $arrayScope[ base_sublevels_iteration ]['childs'] = [] : o[base_iteration]['childs'] = [];

                let haveNestable = $(child).find( opts.nestableList ).first();



                if( haveNestable.children( opts.domThreeItem ).length > 0 ) {
                    WalkerTexasRanger( haveNestable , $arrayScope ? $arrayScope[ base_sublevels_iteration ]['childs'] : o[base_iteration]['childs'], true );
                }

                if($isSubLevel) {
                    base_sublevels_iteration++;
                }
                if($isSubLevel == false) {
                    base_iteration++;
                    base_sublevels_iteration = 0;
                }

            })
        }

        // load menu three
        WalkerTexasRanger();

        return o;

    };
})(jQuery);
