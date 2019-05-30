// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.utiles.ctrfuncion',
        'gmo.logistica.mtafamilia.ctrListado',
        'gmo.logistica.mtasubfamilia.ctrListado',
        'gmo.logistica.mtagrupofam.ctrListado',
        'gmo.logistica.mtatarifadetalle.ctrMtto',
        'gmo.logistica.mtatarifa.ctrMain'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.logistica.mtatarifa.vpmain',{renderTo: Ext.getBody()});
    }

});
