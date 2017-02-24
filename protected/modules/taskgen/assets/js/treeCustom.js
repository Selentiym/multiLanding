/**
 * Created by user on 24.02.2017.
 */
function createStatuses(branch) {
    var status = branch.extra;
    var imageName = '';
    var imageAlt = '';
    //console.log(branch.extra);
    if (status.accepted == 1) {
        imageName = 'tick_small.png';
        imageAlt = 'Принято';
    } else if (status.handedIn == 1) {
        imageName = 'handedIn.png';
        imageAlt = 'Задание сдано';
        branch.element.addClass('handedIn');
    } else if (status.QHandedIn == 1) {
        imageName = 'QHandedIn.png';
        imageAlt = 'Просьба рассмотреть';
        branch.element.addClass('QHandedIn');
    } else if (status.notEmpty == 1){
        imageName = 'writing.png';
        imageAlt = 'Текст в разработке';
    } else if (status.keysGenerated > 0) {
        imageName = 'empty.png';
        imageAlt = 'Ожидает начала работы автора';
    } else if (status.hasKeys > 0) {
        imageName = 'keys_loaded.png';
        imageAlt = 'Ключи загружены';
    } else {
        imageName = 'new.png';
        imageAlt = 'Задание пустое';
    }
    branch.buttonContainer.append($('<img>',{
        src:TaskGenModule.baseAssets+'/images/'+imageName,
        alt: imageAlt,
        title: imageAlt,
        css:{
            height:'20px'
        }
    }));
}