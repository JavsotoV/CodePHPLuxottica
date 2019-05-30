// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.promocion.prmplantilla.ctrMain',
        'gmo.global.utiles.ctrfuncion',
        'gmo.promocion.prmplantilla.ctrMtto',
        'gmo.promocion.prmplantillacatalogo.ctrMtto',
        'gmo.promocion.prmplantilla.ctrListado',
        'gmo.logistica.mtafamilia.ctrListado',
        'gmo.logistica.mtasubfamilia.ctrListado',
        'gmo.logistica.mtagrupofam.ctrListado',
        'gmo.promocion.prmplantillacatalogo.ctrMttoItem'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.promocion.prmplantilla.vpMain');
    }

});
