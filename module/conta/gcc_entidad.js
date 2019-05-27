// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});

Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gcc.entidad.ctrMain',
        'gmo.global.glbconfig.ctrListado',
        'gmo.gcc.entidad.ctrMtto',
        'gmo.global.glbpersona.ctrListado'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gcc.entidad.vpmain', {renderTo: Ext.getBody()});
    }

});
