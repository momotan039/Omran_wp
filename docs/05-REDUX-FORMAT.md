# Redux Fields Format Guide

Format guide for Redux textarea fields.

## Risks Section (risks_items)
**Format:** `Title | Description` (one per line)

```
انسداد متكرر | يعطّل خطوط الإنتاج ويوقف العمل.
تآكل سريع | يؤدي إلى تسرّب الروائح والمياه.
```

## Sectors Section (sectors_items)
**Format:** `Title | Description | Icon` (one per line)

**Icons:** `residential`, `industrial`, `hospitality`

```
القطاع السكني | حلول للصرف المنزلي. | residential
القطاع الصناعي | جريلات تتحمل الأوزان الثقيلة. | industrial
```

## Stainless Steel Section (stainless_items)
**Format:** One feature per line (simple text)

```
مقاومة عالية للتآكل في البيئات الرطبة.
عمر افتراضي طويل وصيانة شبه معدومة.
```

## Tips
- Use `|` (pipe) to separate fields
- Each line = one item
- Empty lines ignored
- Spaces auto-trimmed

