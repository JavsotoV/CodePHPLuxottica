// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.pos.importar.ctrMtto',
        'gmo.global.utiles.ctrfuncion',
        'gmo.pos.importar.ctrMain'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.pos.importar.vpmain', {renderTo: Ext.getBody()});
    }

});
