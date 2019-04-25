// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});


Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.global.glbconfig.oficina.ctrMain',
        'gmo.global.glbconfig.oficina.ctrMtto',
        'gmo.global.glbubigeo.ctrlstubigeo'
    ],
    name: 'luxottica',
        
    launch: function() {
        Ext.create('luxottica.view.gmo.global.glbconfig.oficina.vpMain', {renderTo: Ext.getBody()});
    }

});
