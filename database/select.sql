select i.item_name, i.item_description, i.date_posted, t.tag_name, c.category_name
from items i left join item_tags it on it.item_id = i.item_id 
left join tags t on t.tag_id = it.tag_id 
left join category c on c.category_id = i.category_id
where i.item_name like '%jar%' 
or i.item_description like '%jar%' 
or t.tag_name like '%jar%'
or c.category_name like '%books%'

