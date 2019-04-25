// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gma.tiposerviciopais.ctrMain',
        'gmo.gma.tiposerviciopais.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gma.tiposerviciopais.vpmain');
    }

});
