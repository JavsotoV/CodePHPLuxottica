// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.pos.consulta.encargo.ctrMain'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.pos.consulta.encargo.vpmain', {renderTo: Ext.getBody()});
    }

});
