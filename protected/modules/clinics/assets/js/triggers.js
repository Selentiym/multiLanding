/**
 * Created by user on 02.03.2017.
 */

Triggers = {};
Triggers.objs = [];

function Trigger(params){
    if (typeof params != 'object') {
        params = {};
    }
    var me = {};
    me.url = params.url;
    me.verbiage = params.verbiage;
    me.children = [];
    me.element = $("#" + params.elementId);
    me.beforeDataUpdate = params.beforeDataUpdate;
    me.afterDataUpdate = params.afterDataUpdate;
    me.dataUpdate = params.dataUpdate;
    me.uncheckedValue = params.uncheckedValue;
    $(document).ready(function(){
        if (params.parentVerb) {
            me.parent = Triggers.objs[params.parentVerb];
        }
        for (var i = 0; i < params.childrenVerbs.length; i++) {
            var child = Triggers.objs[params.childrenVerbs[i]];
            if (child) {
                me.children.push(child);
            }
        }
    });
    me.element.change(function(){
        var val = me.element.val();
        if (me.element.is('input[type=checkbox]')) {
            if (!me.element.is(':checked')) {
                val = me.uncheckedValue;
            }
        }
        for (var i = 0; i < me.children.length; i++) {
            me.children[i].parentChanged(val);
        }
    });
    me.parentChanged = function(newVal){
        //alert(newVal + ' \n' + me.url);
        if (newVal) {
            $.post(me.url, {
                newVal: newVal,
                parent: me.parent.verbiage
            }, null, "JSON").done(function (data) {
                if (typeof me.beforeDataUpdate == 'function') {
                    me.beforeDataUpdate.call(me, data);
                }
                if (typeof me.dataUpdate == 'function') {
                    me.dataUpdate.call(me, data);
                } else {
                    me.element.html(data.html);
                }
                if (typeof me.afterDataUpdate == 'function') {
                    me.afterDataUpdate.call(me, data);
                }
            });
        } else {
            me.element.val('');
            me.element.attr('disabled','disabled');
        }
    };
    Triggers.objs[me.verbiage] = me;
    return me;
}