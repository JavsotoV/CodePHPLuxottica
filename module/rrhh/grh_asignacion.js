// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.glbconfig.ctrListado',
        'gmo.global.glbpersona.ctrListado',
        'gmo.grh.grhasignacion.ctrMain',
        'gmo.grh.grhasignacion.ctrMtto',
        'gmo.grh.grhcentrolaboral.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.grh.grhasignacion.vpMain');
    }

});
