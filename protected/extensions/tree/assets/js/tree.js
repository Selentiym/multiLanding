/**
 * Created by user on 20.02.2017.
 */
if (typeof Tree == 'undefined') {
    Tree = {};
}
var loadingImage = $('<img>', {
    src: Tree.baseAssets + '/images/loading.gif',
    css:{
        width:"20px",
        height:"20px"
    }
});
//var loadingImage = $('<span>', {
//    src: Tree.baseAssets + '/images/loading.gif',
//    css:{
//        display:"inline-block",
//        width:"20px",
//        height:"20px"
//    }
//}).append('img');
function TreeBranch(parent, param){
    var me = {};
    if (!(param instanceof Object)) { return; }
    //console.log(param);
    //Сохраняем свой id, иначе не будет детей
    me.id = param.id;
    //Понадобится где-нибудь
    me.name = param.name;
    //Хранится специфичная информация, изменяемая в зависимости от типа отображаемого объекта.
    me.extra = param.extra;
    //console.log(me);
    if (!me.extra) {
        me.extra = {};
        //alert('no extra');
    }
    //Сохраняем родителя, иначе не будет отображения на странице
    //Родителя полностью рекурсивно копируем, потом понадобится
    me.parent = $.extend({},parent);
    //Детей пока нет до первого нажатия
    me.children = [];
    //Детей пока не искали
    me.searched = false;

    //Таким образом сохраняем всевозможные атрибуты, передаваемые от родителя к детям
    //Среди них url, method и тд
    //При этом все новые методы/атрибуты должны замениться на дочерние
    //me = $.extend(parent, me);
    me.tree = parent.tree;
    me.url = parent.url;
    me.toHref = parent.toHref;
    me.childFunc = parent.childFunc;
    me.generateButtons = parent.generateButtons;
    me.method = parent.method;
    me.clickHandler = parent.clickHandler;

    /**
     *@todo вынести как-то в отдельную функцию, передаваемую в качестве параметров в будущем
     */
        //Элемент, отображающий ветку дерева
    me.element = $('<li>',{
        "class":"treeBranch"
    });
    me.expandEl = $('<span>',{
        "class":"expand"
    });
    if (me.extra.hasChildren) {
        me.expandEl.addClass('hasChildren');
        me.expandEl.click(function(){
            me.toggle();
        });
    }
    me.element.append(me.expandEl);
    //В нем содержится название ветки (этот же элемент будет отвечать за выделение)
    me.textEl = $('<div>',{
        "class":"branchName"
    });
    me.link = $('<span>',{href: me.toHref()});
    //toEdit(me.link,Tree.baseUrl + '/task/rename/'+me.id);
    me.textEl.html(me.link.append(param.name));
    me.textEl.click(function(e){
        //Если нажат shift
        if ((e.shiftKey)&&(TreeBranch.prototype.lastSelected)) {
            var indLast = me.parent.children.indexOf(TreeBranch.prototype.lastSelected);
            if (indLast == -1) {
                return;
            }
            var indCur = me.parent.children.indexOf(me);
            if (indCur > indLast) {
                var sv = indLast;
                indLast = indCur;
                indCur = sv;
            }
            for (var i = indCur; i <= indLast; i++) {
                me.parent.children[i].setSelected(true);
            }
            e.preventDefault();
            return;
        }
        if (!e.ctrlKey) {
            me.tree.unselectAll();
        }
        me.toggleSelected();
    });
    /*me.textEl.click(function(e){
     if (me.clickHandler(e)){
     me.toggle();
     }
     });*/
    //И элемент с детьми
    me.element.append(me.textEl);
    me.buttonContainer = $('<span>',{'class':'buttonContainer'});
    if (typeof me.generateButtons == 'function') {
        me.generateButtons(me);
    }
    me.element.append(me.buttonContainer);
    me.childrenContainer = $('<ul>',{
        "class":"branchChildren",
        css:{
            display:"none"
        }
    });
    me.element.append(me.childrenContainer);

    //Присваиваем элемент контейнеру
    me.parent.childrenContainer.append(me.element);
    me.iterateOverChildren = function(callback, obtainChildren){
        if (typeof callback == 'function') {
            if (me.children.length) {
                _.each(me.children, callback);
            } else {
                if ((obtainChildren)&&(!me.searched)&&(me.extra.hasChildren)) {
                    me.getChildren(null, callback);
                }
            }
        }
    };
    me.iterateOverDescendants = function (callback, obtainChildren) {
        if (typeof callback == 'function') {
            me.iterateOverChildren(function (a) {
                callback(a);
                //console.log(a);
                //console.log(obtainChildren);
                a.iterateOverDescendants(callback, obtainChildren);
            }, obtainChildren);
        }
    };
    /*
     me.iterateOverDescendants = function(callback, obtainChildren){
     if ((typeof callback == 'function')&&(me.children)) {
     _.each(me.children, function(a, b, c){
     callback(a, b, c);
     a.iterateOverDescendants(callback);
     });
     }
     };*/
    me.iterateOverSelfAndDescendants = function(callback, obtainChildren){
        if (typeof callback == 'function') {
            callback(me);
            me.iterateOverDescendants(callback);
        }
    };
    /**
     * Отвечает за создание детей. Обращается на сервер и получает своих потомков,
     * затем инициализирует их
     */
        //Вынесено для использования в дальнейшем
        //вне рамок массового обращения на сервер.
    me.createChild = function(el){
        var child = me.childFunc(me, el);
        me.children.push(child);
        if (me.tree.expandedIdsInitial.indexOf(child.id) != -1) {
            child.toggle();
        }
        if (typeof callback == 'function') {
            callback(child);
        }
        return child;
    };
    me.getChildren = function(noExpandedChange, callback){
        me.childrenContainer.toggle(noExpandedChange);
        me.childrenContainer.html(loadingImage.clone());
        $.ajax({
            url: me.url,
            //method:"POST",
            dataType:"json",
            //method:me.method,
            data:{
                id: me.id,
                param: param
            }
        }).done(function (data) {
            me.childrenContainer.html('');
            _.each(data, function(el){
                var child = me.createChild(el);
                //console.log(el);
            });
            /*if (data.length == 0) {
             me.childrenContainer.append('Низший уровень вложенности');
             }*/
            me.searched = true;

        });
    };
    /**
     * Функция, отвечающая за раскрывание списка дочерних элементов
     */
    me.opened = false;
    me.toggle = function(noExpandedChange){
        me.opened = !me.opened;
        if (me.searched) {
            me.childrenContainer.toggle(500);
        } else {
            me.getChildren();
        }
        /*if (!noExpandedChange) {
         me.tree.toggleExpanded(me.id);
         }*/
        me.expandEl.toggleClass('opened');
        me.tree.setExpanded(me.id,me.expandEl.hasClass('opened'));
    };
    me.setOpened = function(val){
        me.opened = val;
        if (me.opened) {
            if (me.searched) {
                me.childrenContainer.show(500);
            } else {
                me.getChildren();
            }
            me.expandEl.addClass('opened');
            me.tree.setExpanded(me.id,true);
        } else {
            me.childrenContainer.hide(500);
        }
    };
    me.setSelected = function(val){
        if (val) {
            me.selected = true;
            me.tree.setExpanded(me.parent.id, true);
            TreeBranch.prototype.lastSelected = me;
            me.element.addClass('selected');
        } else {
            me.selected = false;
            TreeBranch.prototype.lastSelected = null;
            me.element.removeClass('selected');
        }
    };
    me.setSelected(false);
    me.toggleSelected = function(){
        me.selected = !me.selected;
        me.element.toggleClass('selected');
        if (me.selected) {
            TreeBranch.prototype.lastSelected = me;
        } else {
            TreeBranch.prototype.lastSelected = null;
        }
    };
    return me;
}
ControlButton.prototype.actionForOneCountChecks = function(collection){
    if (ControlButton.prototype.hasAnythingCheck(collection)) {
        return ControlButton.prototype.tooManyCheck(collection);
    } else {
        return false;
    }
};
function ControlButton(value, className, callback, tree, param, preValidator){
    var me = {};
    //Сохраняем дерево, тк именно оно даст элементы
    me.tree = tree;
    if (!className) {className = '';}
    if (!param) {param = '';}

    if (typeof preValidator != 'function') {
        me.preValidator = ControlButton.prototype.hasAnythingCheck;
    } else if (preValidator === true) {
        me.preValidator = function(){return true};
    } else{
        me.preValidator = preValidator;
    }
    var tag;
    if (!param.tag) {
        tag = 'span';
    } else {
        tag = param.tag;
    }
    //Создаем элемент кнопки. Все стили накладываются внешне.
    me.element = $('<' + tag + '>', $.extend({
        "class":"button " + className
    },param)).append(value);
    //Вешаем действие кнопки.
    me.element.click(function(event){
        //Если нет элементов, то и делать нечего
        if (me.tree) {
            //Ищем все элементы
            var elems = me.tree.getSelected();
            if (me.preValidator(elems)) {
                //Не всегда действие можно применить ко всем элементам.
                var stop = false;
                _.each(elems, function (el) {
                    if (!stop) {
                        stop = callback(el, event, elems);
                    }
                });
            }
        } else {
            alert('no tree');
        }
    });
    me.tree.addButton(me);
    return me;
}
function TreeStructure(url, param){
    var me = {};

    me.url = url;
    if (!param) {
        param = {};
    }
    param = $.extend({
        method: "post",
        id: 0,
        name: '',
        childFunc: TreeBranch,
        clickHandler: function(e) {return true;},
        toHref: function(){
            if (this.id) {
                return '#';
            }
        },
        extra:{
            hasChildren: 1
        },
        elementId: "TreeContainer"
    },param);
    me.childrenContainer = $('<ul>',{
        "class":"treeRoot"
    });
    me.childFunc = param.childFunc;
    me.clickHandler = param.clickHandler;
    me.toHref = param.toHref;
    me.generateButtons = param.generateButtons;
    me.tree = me;
    me.element = $("#"+param.elementId);
    me.element.addClass("TreeContainer");
    me.element.html(me.childrenContainer);

    //Задаем имя, в котором хранить информацию
    me.cookieName = 'TreeExpandedIds'+me.element.attr('id');
    //Получаем айдишники развернутых пунктов
    var cookie;
    me.expandedIds = [];
    if (cookie = $.cookie(me.cookieName)) {
        me.expandedIdsInitial = JSON.parse(cookie);
    }

    if (!(me.expandedIdsInitial instanceof Array)) {
        me.expandedIdsInitial = [];
    }

    me.expandedIdsInitial = _.unique(me.expandedIdsInitial);
    me.toggleExpanded = function(id){
        var ind = me.expandedIds.indexOf(id);
        if (ind != -1) {
            me.expandedIds.splice(ind, 1);
        } else {
            me.expandedIds.push(id);
        }
        //Сохраняем результат
        $.cookie(me.cookieName, JSON.stringify(me.expandedIds));
        //console.log(me.expandedIds);
    };
    me.setExpanded = function(id, val){
        var state = me.expandedIds.indexOf(id) != -1;

        if (state != val) {
            me.toggleExpanded(id);
        }
    };

    //Важно, чтобы первый элемент создавался именно здесь, иначе в его параметры
    // попадут лишние функции - будет illigal invokation
    me.firstEl = me.childFunc(me, param);
    me.firstEl.toggle();
    if (!param.container) {
        param.container = $("body");
    }

    me.buttonContainer = $("<div>",{
        "class":"controls"
    });
    me.addButton = function(button){
        me.buttonContainer.append(button.element);
    };
    if (typeof param.generatePanel == 'function') {
        console.log(me);
        if (param.generatePanel(me)) {
            me.element.prepend(me.buttonContainer);
        }
    }

    me.unselectAll = function(){
        //alert('implement unselectAll');
        me.firstEl.iterateOverSelfAndDescendants(function(el){
            el.setSelected(false);
        });
    };

    me.getSelected = function(){
        console.log('getselected');
        var toGive = [];
        me.firstEl.iterateOverSelfAndDescendants(function(elem){
            if (elem.selected) {
                toGive.push(elem);
            }
        });
        //console.log(toGive);
        return toGive;
    };
    return me;
}