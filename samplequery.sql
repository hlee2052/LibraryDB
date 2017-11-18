create view BookCatalog(mediaid,booktitle,reserved,availability,locname) as
	select B.mediaid,B.booktitle,M.reserved,M.availability,L.locname
	from book B,media M,location L
	where B.mediaid=M.mediaid and L.lid=M.lid;

select * from BookCatalog;
