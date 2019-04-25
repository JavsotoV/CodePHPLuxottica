// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gma.resolutor.ctrMain',
        'gmo.gma.resolutor.ctrMtto',
        'gmo.global.utiles.ctrfuncion',
        'gmo.gma.responsable.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gma.resolutor.vpmain');
    }

});
