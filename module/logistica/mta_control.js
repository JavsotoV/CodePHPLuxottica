// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.logistica.mtacontrol.ctrMain',
        'gmo.logistica.mtacontrol.ctrMtto',
        'gmo.global.utiles.ctrfuncion'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.logistica.mtacontrol.vpmain');
    }

});
