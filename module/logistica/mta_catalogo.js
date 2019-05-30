// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.logistica.mtacatalogo.ctrMain',
        'gmo.logistica.mtacatalogo.ctrMtto',
        'gmo.logistica.mtafamilia.ctrListado',
        'gmo.logistica.mtasubfamilia.ctrListado',
        'gmo.logistica.mtagrupofam.ctrListado',
        'gmo.logistica.mtacatalogotratamiento.ctrlstpendiente',
        'gmo.global.utiles.ctrfuncion',
        'gmo.logistica.mtatarifadetalle.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.logistica.mtacatalogo.vpmain');
    }

});
