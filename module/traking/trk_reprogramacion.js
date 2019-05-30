// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.pos.reprogramacion.ctrMain',
        'gmo.pos.reprogramacion.ctrMtto',
        'gmo.global.utiles.ctrfuncion'
    ],
    name: 'luxottica',
    title: 'Reprogramacion de Encargo',

    launch: function() {
        Ext.create('luxottica.view.gmo.pos.reprogramacion.vpmain', {renderTo: Ext.getBody()});
    }

});
