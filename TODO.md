Pre-order Page Implementation Todo:

1. Add GET parameters 'tab' and 'page' to pre-order.php.
2. Define logic to filter books based on the 'tab' value:
   - bestseller: books with highest sales/popularity (simulate by order or attribute)
   - new_release: recent release_date descending
   - coming_soon: books with release_date in the future
   - fast_delivery: books flagged for fast delivery (assumed attribute)
3. Implement SQL pagination with LIMIT and OFFSET based on 'page' parameter.
4. Update tab buttons to links including 'tab' param and visually reflect active tab.
5. Add pagination links showing pages with 'tab' param preserved.
6. Test filtering and pagination working as expected.
