// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gma.servicio.ctrMain',
        'gmo.gma.servicio.ctrMtto',
        'gmo.gma.requerimiento.ctrMtto',
        'gmo.global.utiles.ctrfuncion'
    ],
    name: 'luxottica',
    
    launch: function() {
        Ext.create('luxottica.view.gmo.gma.servicio.vpmain');
    }

});
