select group_concat(id, ' ', lastname, ' ', firstname, ' ', company ,'<BR>') as duplicati, count(pin) c, pin from visual_phonebook where pin!='' group by pin having c>1