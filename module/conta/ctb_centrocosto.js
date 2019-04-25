// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.ctbcentrocosto.ctrMain',
        'gmo.global.utiles.ctrfuncion',
        'gmo.global.ctbcentrocosto.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.global.ctbcentrocosto.vpmain', {renderTo: Ext.getBody()});
    }

});
