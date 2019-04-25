// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});

Ext.application({
     appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.glbgrupoinmobiliaria.ctrMain',
        'gmo.global.glbgrupoinmobiliaria.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.global.glbgrupoinmobiliaria.vpmain', {renderTo: Ext.getBody()});
    }

});
