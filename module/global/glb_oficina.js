// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.utiles.ctrfuncion',
        'gmo.global.glbubigeo.ctrlstubigeo',
        'gmo.global.glbconfig.oficina.ctrMain',
        'gmo.global.glbconfig.oficina.ctrMtto'        
    ],
    views: [
        'gmo.global.glbubigeo.winlistado'
    ],
    name: 'luxottica',
        
    launch: function() {
        Ext.create('luxottica.view.gmo.global.glbconfig.oficina.vpMain', {renderTo: Ext.getBody()});
    }

});
