// @require @packageOverrides
Ext.Loader.setConfig({
    enabled: true
});

Ext.application({
    appFolder: '../../../../luxottica/app/luxottica',
    appProperty: 'luxottica',
    controllers: [
        'gmo.gma.ticket.ctrMain',
        'gmo.gma.ticket.ctrMtto',
        'gmo.gma.binary.ctrPreview',
        'gmo.gma.seguimiento.ctrMtto',
        'gmo.gma.ticketdet.ctrMttorst',
        'gmo.global.utiles.ctrfuncion',
        'gmo.gma.ticketdet.ctrlistado',
        'gmo.gma.message.ctrMtto'
    ],
    name: 'luxottica',

    launch: function() {
        Ext.create('luxottica.view.gmo.gma.ticket.vpmain');
    }

});
