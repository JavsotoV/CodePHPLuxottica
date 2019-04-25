// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gcc.rendicion.ctrMain',
        'gmo.gcc.rendicion.ctrMtto',
        'gmo.gcc.rendiciondet.ctrMtto',
        'gmo.gcc.incidencia.ctrMtto',
        'gmo.gcc.rechazo.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gcc.rendicion.vpmain');
    }

});
