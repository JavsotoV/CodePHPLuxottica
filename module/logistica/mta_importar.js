// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.utiles.ctrfuncion',
        'gmo.logistica.mtaimportar.ctrMtto',
        'gmo.logistica.mtaimportar.ctrMain'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.logistica.mtaimportar.vpmain');
    }

});
