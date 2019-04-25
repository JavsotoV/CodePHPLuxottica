// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gcc.concepto.ctrMain',
        'gmo.gcc.concepto.ctrMtto',
        'gmo.global.utiles.ctrfuncion'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gcc.concepto.vpMain');
    }

});
