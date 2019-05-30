// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'encargo',
    controllers: [
        'gmo.logistica.mtaregistro.ctrMain',
        'gmo.logistica.mtaregistro.ctrMtto',
        'gmo.logistica.mtacatalogo.ctrListado',
        'gmo.logistica.mtaregistrodet.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.logistica.mtaregistro.vpnmain');
    }

});
