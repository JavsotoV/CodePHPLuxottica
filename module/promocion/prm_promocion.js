// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.utiles.ctrfuncion',
        'gmo.promocion.prmpromocion.ctrMain',
        'gmo.promocion.prmpromocion.ctrMtto',
        'gmo.promocion.prmpromocioncatalogo.ctrMtto',
        'gmo.promocion.prmcatalogo.ctrMtto',
        'gmo.promocion.prmlocal.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.promocion.prmpromocion.vpMain');
    }

});
