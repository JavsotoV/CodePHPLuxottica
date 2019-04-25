Ext.Loader.setConfig({
    enabled: true
});

Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.glbtienda.ctrMain',
        'gmo.global.glbtienda.ctrMtto',
        'gmo.global.utiles.ctrfuncion',
        'gmo.global.glbubigeo.ctrlstubigeo',
        'gmo.global.ctbcentrocosto.ctrlstcentrocosto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.global.glbtienda.vpmain', {renderTo: Ext.getBody()});
    }

});
